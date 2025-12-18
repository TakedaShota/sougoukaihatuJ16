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
     * ログイン処理（電話番号のみ）
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

        // 🔽 ここから遷移制御（順番が重要）

        // 管理者は admin
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // 未承認ユーザーは waiting
        if (!$user->is_approved) {
            return redirect()->route('waiting');
        }

        // 承認済み一般ユーザーは掲示板
        return redirect()->route('threads.index');
    }

    /**
     * ログアウト
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
