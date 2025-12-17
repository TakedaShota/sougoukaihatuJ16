<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * ログイン画面表示
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * ログイン処理（開発用：電話番号のみ）
     */
    public function login(Request $request)
    {
        // 電話番号必須チェック
        $request->validate([
            'phone' => 'required',
        ]);

        // 電話番号でユーザー取得
        $user = User::where('phone', $request->phone)->first();

        // ユーザーが存在しない場合
        if (!$user) {
            return back()->withErrors([
                'login' => '電話番号が登録されていません。',
            ]);
        }

        // ログイン
        Auth::login($user);
        $request->session()->regenerate();

        // 承認されていない場合は waiting へ
        if ($user->is_approved == 0) {
            return redirect('/waiting');
        }

        // 管理者なら admin へ（※今は制限なしなので任意）
        if ($user->is_admin == 1) {
            return redirect('/admin');
        }

        // 一般ユーザーは threads.index
        return redirect('threads.index');
    }

    /**
     * ログアウト
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
