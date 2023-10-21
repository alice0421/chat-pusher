<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{
    public function get (User $receiver): Response
    {
        return Inertia::render('Chat/Index', [
            'sender' => Auth::user(),
            'receiver' => $receiver,
            'messages' => Chat::with('sender', 'receiver')->orderBy('created_at', 'asc')->get(),
        ]);
    }

    public function store (Request $request, User $receiver): Chat
    {
        $input = $request->only(['message']);
        $input['sender_id'] = Auth::id();
        $input['receiver_id'] = $receiver->id;
        $message = Chat::create($input);

        // 送信者がPusherから受け取った分を表示しないようにする (Vueによる表示との重複防止)
        event((new MessageSent(
            $message->sender_id,
            $message->receiver_id,
            $message->load('sender', 'receiver')
        ))->dontBroadcastToCurrentUser());
        

        return $message->load('sender', 'receiver');
    }
}
