<?php

namespace App\Http\Controllers;

use App\Models\InterestRequest;
use App\Models\Thread;
use Illuminate\Http\Request;

class InterestRequestController extends Controller
{
    public function store(Thread $thread, Request $request)
    {
        $user = auth()->user();

        if ($thread->user_id === $user->id) {
            return back()->withErrors(['interest' => '自分の投稿には送れません']);
        }

        InterestRequest::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'from_user_id' => $user->id,
            ],
            [
                'to_user_id' => $thread->user_id,
                'status' => 'pending',
            ]
        );

        return back()->with('message', '興味ありを送信しました');
    }

    // 投稿者側：受信一覧
    public function incoming()
    {
        $user = auth()->user();

        $requests = InterestRequest::with(['thread', 'fromUser'])
            ->where('to_user_id', $user->id)
            ->latest()
            ->get();

        return view('interest.incoming', compact('requests'));
    }

    public function approve(InterestRequest $interestRequest)
    {
        $user = auth()->user();
        abort_unless($interestRequest->to_user_id === $user->id, 403);

        $interestRequest->update(['status' => 'approved']);

        return back()->with('message', '承認しました。マッチ成立です！');
    }

    public function reject(InterestRequest $interestRequest)
    {
        $user = auth()->user();
        abort_unless($interestRequest->to_user_id === $user->id, 403);

        $interestRequest->update(['status' => 'rejected']);

        return back()->with('message', '拒否しました');
    }

    // 申請者側：送信一覧
    public function outgoing()
    {
        $user = auth()->user();

        $requests = InterestRequest::with(['thread', 'toUser'])
            ->where('from_user_id', $user->id)
            ->latest()
            ->get();

        return view('interest.outgoing', compact('requests'));
    }

    // マッチ成立一覧（approvedのみ）
    public function matches()
    {
        $user = auth()->user();

        $matches = InterestRequest::with(['thread', 'fromUser', 'toUser'])
            ->where('status', 'approved')
            ->where(function ($q) use ($user) {
                $q->where('from_user_id', $user->id)
                  ->orWhere('to_user_id', $user->id);
            })
            ->latest()
            ->get();

        return view('matches.index', compact('matches'));
    }
}
