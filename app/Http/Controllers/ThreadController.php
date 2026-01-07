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
        $threads = Thread::with('user')
            ->withCount('comments')
            ->latest()
            ->paginate(10);

        return view('threads.index', compact('threads'));
    }

    /**
     * スレッド詳細
     */
    public function show(Thread $thread)
    {
        $comments = Comment::where('thread_id', $thread->id)
            ->whereNull('parent_id')
            ->latest()
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
     * スレッド保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'body'            => 'required|string',
            'image'           => 'nullable|image|max:2048',
            'enable_interest' => 'nullable|boolean',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('threads', 'public');
        }

        Thread::create([
            'title'           => $request->title,
            'body'            => $request->body,
            'image'           => $path,
            'user_id'         => Auth::id(),
            'enable_interest' => $request->boolean('enable_interest'),
            'interest_count'  => 0,
        ]);

        return redirect()->route('threads.index');
    }

    /**
     * 編集画面
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

    /**
     * 興味あり
     */
    public function interest(Thread $thread)
    {
        if (!$thread->enable_interest) {
            return back();
        }

        $thread->increment('interest_count');

        return back();
    }
}
