<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * コメント（親コメント or 返信）を保存
     */
    public function store(Request $request, Thread $thread)
    {
        // バリデーション
        $data = $request->validate([
            'body'      => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // 投稿者（ゲストの場合は null）
        $userId = Auth::id(); 

        // コメント作成
        Comment::create([
            'thread_id' => $thread->id,
            'user_id'   => $userId,
            'body'      => $data['body'],
            'parent_id' => $data['parent_id'] ?? null,
        ]);

        return redirect()->route('threads.show', $thread)
                         ->with('status', 'コメントを投稿しました');
    }
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment); // 投稿主のみ
        $comment->delete();
        return redirect()->back()->with('status', 'コメントを削除しました');
    }
}
