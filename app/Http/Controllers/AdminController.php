<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * 管理者トップページ
     * 管理者メニューを表示
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * 承認待ちユーザー一覧
     */
    public function pending()
    {
        // 管理者以外で、承認されていないユーザー
        $users = User::where('is_admin', 0)
                     ->where('is_approved', 0)
                     ->get();

        return view('admin.pending', compact('users'));
    }

    /**
     * ユーザー承認処理
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->is_approved = 1;  // 承認
        $user->save();

        return back()->with('message', 'ユーザーを承認しました。');
    }

    /**
     * ユーザー却下（削除）
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);

        $user->delete();  // 却下 = 削除

        return back()->with('message', 'ユーザーを削除しました。');
    }

    /**
     * ログ一覧（必要に応じてあとで作成）
     */
    public function logs()
    {
        return view('admin.logs');
    }
}
