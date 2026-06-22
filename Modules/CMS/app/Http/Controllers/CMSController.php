<?php

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CMS\Models\Post;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostSubmittedNotification;
use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CMSController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Post::query()->with('author');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhere('category', 'like', "%{$search}%");
        }

        if ($request->filled('approval_status') && $request->approval_status !== 'all') {
            $query->where('approval_status', $request->approval_status);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return view('cms::index', compact('posts'));
    }

    public function create()
    {
        return view('cms::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'slug'            => 'nullable|string|max:255|unique:posts,slug',
            'category'        => 'required|string|max:255',
            'read_time'       => 'nullable|string|max:50',
            'excerpt'         => 'nullable|string|max:1000',
            'body'            => 'required|string',
            'thumbnail'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'approval_status' => 'required|in:draft,submitted,approved,rejected',
        ]);

        $validated['user_id'] = auth()->id();

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        if ($validated['approval_status'] === 'approved') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $post = Post::create($validated);

        if ($post->approval_status === 'submitted') {
            $this->notifyPublishers($post);
        }

        return redirect()->route('modules.cms.index')
                         ->with('success', 'Blog post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('cms::edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category'        => 'required|string|max:255',
            'read_time'       => 'nullable|string|max:50',
            'excerpt'         => 'nullable|string|max:1000',
            'body'            => 'required|string',
            'thumbnail'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'approval_status' => 'required|in:draft,submitted,approved,rejected',
        ]);

        if ($validated['approval_status'] === 'approved' && $post->approval_status !== 'approved') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $wasSubmitted = $post->approval_status !== 'submitted' && $validated['approval_status'] === 'submitted';
        
        $post->update($validated);

        if ($wasSubmitted) {
            $this->notifyPublishers($post);
        }

        return redirect()->route('modules.cms.index')
                         ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('modules.cms.index')
                         ->with('success', 'Blog post deleted successfully.');
    }

    public function submitForReview(Post $post)
    {
        $post->update(['approval_status' => 'submitted']);
        $this->notifyPublishers($post);

        return redirect()->back()->with('success', 'Post submitted for review.');
    }

    public function approve(Post $post)
    {
        $post->update([
            'approval_status' => 'approved',
            'published_at' => now(),
        ]);

        if ($post->author) {
            try {
                $post->author->notify(new PostApprovedNotification($post));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Approved notification mail failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Post approved and published.');
    }

    public function reject(Post $post)
    {
        $post->update(['approval_status' => 'rejected']);

        if ($post->author) {
            try {
                $post->author->notify(new PostRejectedNotification($post));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Rejected notification mail failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Post rejected.');
    }

    public function resendNotification(Post $post)
    {
        $this->notifyPublishers($post);

        return redirect()->back()->with('success', 'Notification resent to all Publishers.');
    }

    private function notifyPublishers(Post $post): void
    {
        $publishers = User::permission('cms.approve')->get();

        foreach ($publishers as $publisher) {
            // Always save the in-app (database) notification
            try {
                $publisher->notify(new PostSubmittedNotification($post));
            } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
                // Email failed (e.g. Resend domain not verified) — in-app notification was still stored.
                // Log the issue silently so it doesn't crash the request.
                \Illuminate\Support\Facades\Log::warning('Mail notification failed for publisher #' . $publisher->id . ': ' . $e->getMessage());
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Notification error for publisher #' . $publisher->id . ': ' . $e->getMessage());
            }
        }
    }
}
