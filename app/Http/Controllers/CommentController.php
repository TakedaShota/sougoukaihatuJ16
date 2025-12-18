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
        $data = $request->validate([
            'body'      => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'thread_id' => $thread->id,
            'user_id'   => Auth::id(),
            'body'      => $data['body'],
            'parent_id' => $data['parent_id'] ?? null,
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
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('status', 'コメントを削除しました');
    }
}
