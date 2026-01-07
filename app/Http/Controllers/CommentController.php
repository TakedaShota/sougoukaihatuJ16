<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * コメント（親 or 返信）保存
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
     * コメント削除
     */
    public function destroy(Comment $comment)
    {
        // 権限チェック（本人 or 管理者想定）
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('status', 'コメントを削除しました');
    }
}
