<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $senderId = $request->session()->getId();

        $senderName = auth()->check()
            ? auth()->user()->name
            : 'ゲスト';

        // ★ 自分以外にだけ broadcast
        broadcast(new MessageSent(
            $request->message,
            $senderId,
            $senderName
        ))->toOthers();

        return response()->json([
            'message'    => $request->message,
            'senderId'   => $senderId,
            'senderName' => $senderName,
        ]);
    }
}
