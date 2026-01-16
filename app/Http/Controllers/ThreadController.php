<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Http\Request;
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
     * スレッド作成画面
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * スレッド保存（※1つだけ）
     */
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
            'user_id'         => Auth::id(),
            'enable_interest' => $request->boolean('enable_interest'),
            'interest_count'  => 0,
        ]);

        return redirect()->route('threads.index');
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

        $hasInterested = Auth::check()
            ? $thread->interestedUsers()
                ->where('user_id', Auth::id())
                ->exists()
            : false;

        return view('threads.show', compact(
            'thread',
            'comments',
            'hasInterested'
        ));
    }

    /**
     * 🗑 スレッド削除（投稿者本人のみ）
     */
    public function destroy(Thread $thread)
    {
        if ($thread->user_id !== Auth::id()) {
            abort(403);
        }

        $thread->delete();

        return redirect()
            ->route('threads.index')
            ->with('success', '投稿を削除しました');
    }

    /**
     * ❤️ 興味あり ON / OFF（Ajaxトグル）
     */
    public function interest(Thread $thread)
    {
        if (!$thread->enable_interest) {
            return response()->json(['error' => true], 403);
        }

        $user = Auth::user();

        if ($thread->user_id === $user->id) {
            return response()->json(['error' => true], 403);
        }

        $already = $thread->interestedUsers()
            ->where('user_id', $user->id)
            ->exists();

        if ($already) {
            $thread->interestedUsers()->detach($user->id);
            $thread->decrement('interest_count');
            $liked = false;
        } else {
            $thread->interestedUsers()->attach($user->id);
            $thread->increment('interest_count');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'count' => $thread->interest_count,
        ]);
    }
}
