<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterestRequest;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * チャット画面を表示
     */
    public function show(InterestRequest $interest_request)
    {
        // 1. セキュリティチェック: 自分に関係ないマッチは見れないようにする
        if ($interest_request->from_user_id !== auth()->id() && $interest_request->to_user_id !== auth()->id()) {
            abort(403);
        }

        // 2. メッセージを古い順に取得
        $messages = $interest_request->messages()
                                     ->with('user') // 送信者の情報を取得
                                     ->oldest()     // 古い順に並べる
                                     ->get();

        // 3. チャット相手の特定
        $chatPartner = ($interest_request->from_user_id === auth()->id()) 
                        ? $interest_request->toUser 
                        : $interest_request->fromUser;

        // 4. ビューを表示
        return view('chat.show', compact('interest_request', 'messages', 'chatPartner'));
    }

    /**
     * メッセージを送信
     */
    public function store(Request $request, InterestRequest $interest_request)
    {
        // 1. バリデーション
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // トランザクション開始
        DB::beginTransaction();

        try {
            // 2. メッセージの保存
            $message = Message::create([
                'interest_request_id' => $interest_request->id,
                'user_id'             => auth()->id(),
                'body'                => $request->body,
            ]);

            DB::commit();

            return back();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * ★追加：新着メッセージをJSONで取得（ポーリング用）
     */
    public function getNewMessages(InterestRequest $interest_request, Request $request)
    {
        // 1. セキュリティチェック（他人の部屋を覗けないように）
        if ($interest_request->from_user_id !== auth()->id() && $interest_request->to_user_id !== auth()->id()) {
            abort(403);
        }

        // JavaScriptから送られてきた「最後に表示したID」を取得
        $lastId = $request->input('last_id', 0);

        // それ以降の新しいメッセージだけを取得
        $messages = Message::where('interest_request_id', $interest_request->id)
            ->where('id', '>', $lastId)
            ->with('user') // ユーザー情報も一緒に取得
            ->orderBy('created_at', 'asc')
            ->get();

        // JSON形式に整形
        $formattedMessages = $messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'body' => nl2br(e($msg->body)),
                'is_mine' => $msg->user_id === auth()->id(),
                'created_at' => $msg->created_at->format('H:i'),
                'partner_initial' => mb_substr($msg->user->name ?? '?', 0, 1),
            ];
        });

        return response()->json($formattedMessages);
    }
}