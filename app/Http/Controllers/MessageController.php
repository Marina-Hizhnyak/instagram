<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class MessageController extends Controller
{
    public function chatList()
    {
        $users = Auth::user()->following()->get();
        return view('chat.list', compact('users'));
    }

    public function index(User $user)
    {
        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('chat.index', compact('user', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        broadcast(new \App\Events\MessageSent($message))->toOthers();

        return redirect()->route('chat.index', ['user' => $request->receiver_id])
            ->with('status', 'Message sent successfully');
    }
}
