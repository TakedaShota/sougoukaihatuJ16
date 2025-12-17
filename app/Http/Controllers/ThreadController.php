<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    /**
     * 掲示板一覧
     */
    public function index()
    {
        $threads = Thread::latest()->get();
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
     * （後で使う）スレッド詳細
     */
    // public function show(Thread $thread)
    // {
    //     return view('threads.show', compact('thread'));
    // }
}
