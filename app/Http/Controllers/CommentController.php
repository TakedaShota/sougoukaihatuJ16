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
        $validated = $request->validate([
            'body'      => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(), // ゲストは null
            'body'      => $validated['body'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        return redirect()
            ->route('threads.show', $thread)
            ->with('status', 'コメントを投稿しました');
    }

    /**
     * コメント削除（今は制限なし：開発用）
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()
            ->back()
            ->with('status', 'コメントを削除しました');
    }
}
