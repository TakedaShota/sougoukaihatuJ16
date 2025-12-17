<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewReportNotification;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $report = Report::create([
            'user_id'   => auth()->id(),  // 未ログインなら null
            'thread_id' => $request->thread_id,
            'comment_id'=> $request->comment_id,
            'reason'    => $request->reason,
        ]);

        // 管理者へ通知（role が admin のユーザーに送る例）
        $admins = User::where('is_admin', 1)->get();
        Notification::send($admins, new NewReportNotification($report));

        return back()->with('success', '通報が送信されました。');
    }
}
