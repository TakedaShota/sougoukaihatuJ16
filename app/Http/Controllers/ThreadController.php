<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Comment;
use App\Models\InterestRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // 👈 Gateファサード読み込み

class ThreadController extends Controller
{
    /**
     * スレッド一覧（1ページ6件）
     */
    public function index()
    {
        $threads = Thread::with('user')
            ->latest()
            ->paginate(6);

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

        // このスレッドに対する「自分の興味あり」の状態（未送信なら null）
        $interest = null;

        if (Auth::check() && Auth::id() !== $thread->user_id) {
            $interest = InterestRequest::where('thread_id', $thread->id)
                ->where('from_user_id', Auth::id())
                ->first();
        }

        return view('threads.show', compact('thread', 'comments', 'interest'));
    }

    /**
     * スレッド作成画面
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * スレッド保存処理（★画像と興味あり設定に対応）
     */
    public function store(Request $request)
    {
        // ① バリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'image' => 'nullable|image|max:2048', // 画像は任意、最大2MB
        ]);

        // ② 画像アップロード処理
        $imagePath = null;
        if ($request->hasFile('image')) {
            // storage/app/public/threads フォルダに保存
            $imagePath = $request->file('image')->store('threads', 'public');
        }

        // ③ データベースに保存
        Thread::create([
            'title'   => $request->title,
            'body'    => $request->body,
            'user_id' => Auth::id(),
            'image'   => $imagePath,                 // 画像パス
            'enable_interest' => $request->enable_interest, // 興味ありボタンの表示設定(1 or 0)
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
        // Policyを使って権限チェック（本人以外は削除不可）
        Gate::authorize('delete', $thread);
        
        $thread->delete();

        return redirect()->route('threads.index');
    }
}