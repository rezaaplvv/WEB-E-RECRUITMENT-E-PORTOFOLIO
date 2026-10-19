<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated user.
     */
    public function index(): View
    {
        $user = Auth::user();
        $notifikasi = Notifikasi::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifikasi', 'user'));
    }

    /**
     * Mark a specific notification as read and redirect to target link if provided.
     */
    public function markAsRead(int $id): RedirectResponse
    {
        $user = Auth::user();
        $notifikasi = Notifikasi::where('user_id', $user->id)->findOrFail($id);

        if (! $notifikasi->is_read) {
            $notifikasi->update(['is_read' => true]);
        }

        if (! empty($notifikasi->link)) {
            return redirect($notifikasi->link);
        }

        return back()->with('success', 'Notifikasi telah ditandai sebagai telah dibaca.');
    }

    /**
     * Mark all notifications as read for current user.
     */
    public function markAllAsRead(): RedirectResponse
    {
        $user = Auth::user();
        Notifikasi::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }
}
