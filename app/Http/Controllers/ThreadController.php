<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    /**
     * スレッド一覧
     */
    public function index()
    {
        $threads = Thread::with('user')->latest()->paginate(10);
        return view('threads.index', compact('threads'));
    }

    /**
     * スレッド詳細
     */
    public function show(Thread $thread)
    {
        $thread->load('user');

        // 親コメント取得
        $comments = Comment::where('thread_id', $thread->id)
            ->whereNull('parent_id')
            ->with(['replies.user', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('threads.show', compact('thread', 'comments'));
    }

    /**
     * スレッド作成画面
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * スレッド保存処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        Thread::create([
            'title'   => $request->title,
            'body'    => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('threads.index');
    }

    /**
     * 編集フォーム
     */
    public function edit(Thread $thread)
    {
        return view('threads.edit', compact('thread'));
    }

    /**
     * 更新
     */
    public function update(Request $request, Thread $thread)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        $thread->update($request->only('title', 'body'));

        return redirect()->route('threads.show', $thread);
    }

    /**
     * 削除
     */
    public function destroy(Thread $thread)
    {
        $this->authorize('delete', $thread);
        $thread->delete();

        return redirect()->route('threads.index');
    }
}
