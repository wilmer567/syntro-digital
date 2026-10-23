<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display a listing of messages.
     */
    public function index(): View
    {
        $messages = ContactMessage::latest()->paginate(15);
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display the specified message and mark it as read.
     */
    public function show(ContactMessage $message): View
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Toggle read status.
     */
    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        $message->update([
            'is_read' => ! $message->is_read,
        ]);

        return back()->with('status', 'Estado del mensaje actualizado.');
    }

    /**
     * Remove the specified message.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('status', 'Mensaje eliminado correctamente.');
    }
}
