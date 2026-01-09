<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function send(Request $request)
{
    $request->validate([
        'message'   => 'nullable|string|max:1000',
        'images.*'  => 'nullable|image|max:5120',
        'sender_id' => 'required|string',
    ]);

    $senderId   = $request->sender_id;
    $senderName = auth()->check() ? auth()->user()->name : 'ゲスト';

    $imageUrls = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('chat_images', 'public');
            $imageUrls[] = Storage::url($path);
        }
    }

    broadcast(new MessageSent(
        senderId:   $senderId,
        senderName: $senderName,
        message:    $request->message,
        imageUrls:  $imageUrls
    ))->toOthers();

    return response()->json(['status' => 'ok']);
}
}
