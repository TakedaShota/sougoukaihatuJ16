<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Comment;

class ThreadController extends Controller
{
    // 一覧
    public function index()
    {
        $threads = Thread::withCount('comments')
            ->latest()
            ->paginate(10);

        return view('threads.index', compact('threads'));
    }

    // 詳細
    public function show(Thread $thread)
    {
        $comments = Comment::where('thread_id', $thread->id)
            ->whereNull('parent_id')
            ->latest()
            ->get();

        return view('threads.show', compact('thread', 'comments'));
    }

    // 作成画面
    public function create()
    {
        return view('threads.create');
    }

    // 保存（写真＋興味あり）
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|max:255',
            'body'            => 'required',
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
            // ✅ booleanとして正しく保存
            'enable_interest' => $request->boolean('enable_interest'),
            'interest_count'  => 0,
        ]);

        return redirect()->route('threads.index');
    }

    // 削除（開発中：誰でもOK）
    public function destroy(Thread $thread)
    {
        $thread->delete();
        return redirect()->route('threads.index');
    }

    // 興味ありボタン
    public function interest(Thread $thread)
    {
        // 念のためガード
        if (!$thread->enable_interest) {
            return back();
        }

        $thread->increment('interest_count');

        return back();
    }
}
