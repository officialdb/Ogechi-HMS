<?php

namespace Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        
        return view('notifications::index', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        // If it came via AJAX/JSON
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete a specific notification.
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        
        return back()->with('success', 'Notification deleted.');
    }

    /**
     * Generate a test notification (For Development/Testing).
     */
    public function sendTest()
    {
        // Simple raw database notification since we don't have a dedicated Notification class set up yet.
        Auth::user()->notifications()->create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'type' => 'App\Notifications\SystemAlert',
            'data' => [
                'title' => 'System Alert: Low Stock',
                'message' => 'Amoxicillin is running low in the pharmacy (5 units left).',
                'icon' => 'warning', // info, success, warning, error
                'url' => route('modules.pharmacy.index')
            ],
            'read_at' => null,
        ]);
        
        return back()->with('success', 'Test notification sent to your inbox.');
    }
}
