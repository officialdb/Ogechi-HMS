<?php

namespace Modules\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CMS\Models\Post;
use Illuminate\Support\Str;

class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $posts = $query->latest()->paginate(10)->withQueryString();

        return view('cms::index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cms::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:posts,slug',
            'category'    => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'author_role' => 'nullable|string|max:255',
            'read_time'   => 'nullable|string|max:50',
            'excerpt'     => 'nullable|string|max:1000',
            'body'        => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'required|in:draft,published',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Post::create($validated);

        return redirect()->route('modules.cms.index')
                         ->with('success', 'Blog post created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('cms::edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category'    => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'author_role' => 'nullable|string|max:255',
            'read_time'   => 'nullable|string|max:50',
            'excerpt'     => 'nullable|string|max:1000',
            'body'        => 'required|string',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'required|in:draft,published',
        ]);

        if ($validated['status'] === 'published' && $post->status === 'draft') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists (optional, keeping it simple for now or using Storage::delete)
            if ($post->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $post->update($validated);

        return redirect()->route('modules.cms.index')
                         ->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('modules.cms.index')
                         ->with('success', 'Blog post deleted successfully.');
    }
}
