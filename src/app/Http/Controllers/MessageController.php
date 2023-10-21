<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class MessageController extends Controller
{
    public function get (User $sender, User $receiver): Response
    {
        return Inertia::render('Chat/Index', [
            'messages' => Message::with('sender', 'receiver')->orderBy('created_at', 'asc')->get(),
            'sender' => $sender,
            'receiver' => $receiver,
        ]);
    }

    public function store (Request $request, User $sender, User $receiver): Message
    {
        $input = $request->only(['context']);
        $input['sender_id'] = $sender->id;
        $input['receiver_id'] = $receiver->id;
        $message = Message::create($input);

        // 送信者がPusherから受け取った分を表示しないようにする (Vueによる表示との重複防止)
        event((new MessageSent($message->load('sender', 'receiver')))->dontBroadcastToCurrentUser());

        return $message->load('sender', 'receiver');
    }
}
