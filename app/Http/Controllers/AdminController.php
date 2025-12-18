<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // 管理者トップページ
    public function index()
    {
        return view('admin.dashboard');
    }

    // 承認待ちユーザー一覧
    public function pending()
    {
        $users = User::where('is_admin', 0)
                     ->where('is_approved', 0)
                     ->get();

        return view('admin.pending', compact('users'));
    }

    // ユーザー承認
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = 1;
        $user->save();

        return back()->with('message', 'ユーザーを承認しました。');
    }

    // ユーザー却下
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('message', 'ユーザーを削除しました。');
    }

    // ログ画面 ⭐ 修正ポイント
    public function logs()
    {
        $logs = DB::table('logs')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.logs', compact('logs'));
    }
}
