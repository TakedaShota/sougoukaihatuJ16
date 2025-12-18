<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // ログイン画面
    public function show()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        $request->validate([
            'phone'       => 'required|digits:11', // 11桁固定
            'room_number' => 'required|digits:3',  // 3桁固定
        ]);

        // 電話番号 + 部屋番号でユーザー検索
        $user = User::where('phone', $request->phone)
                    ->where('room_number', $request->room_number)
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'login' => '電話番号または部屋番号が正しくありません。',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // 承認待ちの場合
        if (!$user->is_approved) {
            return redirect()->route('waiting');
        }

        // 管理者の場合
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // 通常ユーザー
        return redirect()->route('dashboard');
    }

    // ログアウト
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
