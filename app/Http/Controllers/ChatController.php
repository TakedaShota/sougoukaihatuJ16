<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;
use App\Models\MessageImage;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
   public function index(Request $request)
{
    $guestId = $request->cookie('guest_id');

    if (!$guestId) {
        $guestId = (string) \Illuminate\Support\Str::uuid();

        cookie()->queue(
            'guest_id',
            $guestId,
            60 * 24 * 30
        );
    }

    $messages = Message::with('images')
        ->orderBy('id')
        ->get();

    return view('chat', compact('messages', 'guestId'));
}




  public function send(Request $request)
{
    $guestId = $request->cookie('guest_id');

    if (!$guestId) {
        $guestId = (string) \Illuminate\Support\Str::uuid();

        cookie()->queue(
            'guest_id',
            $guestId,
            60 * 24 * 30
        );
    }

    $request->validate([
        'message'  => 'nullable|string|max:1000',
        'images.*' => 'nullable|image|max:5120',
    ]);

    DB::beginTransaction();

    try {
        $message = Message::create([
            'user_id'     => auth()->id(),
            'guest_id'    => $guestId, // ← ここが超重要
            'sender_name' => auth()->user()->name ?? 'ゲスト',
            'message'     => $request->message,
        ]);

        $imageUrls = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('chat_images', 'public');
                $url  = Storage::url($path);

                MessageImage::create([
                    'message_id' => $message->id,
                    'image_url'  => $url,
                ]);

                $imageUrls[] = $url;
            }
        }

        DB::commit();

       broadcast(new MessageSent(
            auth()->id(),
            $guestId, // ← 必ず同じ値
            $message->sender_name,
            $message->message,
            $imageUrls
        ))->toOthers();

        return response()->json(['ok' => true]);

    } catch (\Throwable $e) {
        DB::rollBack();
        throw $e;
    }
}
}