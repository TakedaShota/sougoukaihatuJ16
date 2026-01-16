<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 管理者トップ
    public function index()
    {
        return view('admin.dashboard');
    }

    // 承認待ち一覧
    public function pending()
    {
        $users = User::where('is_admin', false)
            ->where('is_approved', false)
            ->get();

        return view('admin.pending', compact('users'));
    }

    // 承認
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return back()->with('message', 'ユーザーを承認しました');
    }

    // 却下
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('message', 'ユーザーを削除しました');
    }

    // ログ
    public function logs()
    {
        $logs = DB::table('logs')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.logs', compact('logs'));
    }
}
