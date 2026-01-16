<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // ログイン画面
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 最低限の入力チェック
        $request->validate([
            'phone'       => 'required|digits:11',
            'room_number' => 'required',
            'password'    => 'required',
        ]);

        // 電話番号と部屋番号のみ正規化（パスワードは触らない）
        $phone = trim(mb_convert_kana($request->phone, 'n'));
        $room  = trim(mb_convert_kana($request->room_number, 'n'));
        $pass  = trim($request->password);

        // ユーザー取得
        $user = User::where('phone', $phone)
                    ->where('room_number', $room)
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'login' => '電話番号または部屋番号が正しくありません',
            ]);
        }

        // ===============================
        // 🔐 パスワード一致チェック（最優先）
        // ===============================
        if (!Hash::check($pass, $user->password)) {
            return back()->withErrors([
                'login' => 'パスワードが正しくありません',
            ]);
        }

        // ===============================
        // 👤 ロール別ルールチェック
        // ===============================
        if ($user->is_admin) {
            // 管理者：8文字以上
            if (strlen($pass) < 8) {
                return back()->withErrors([
                    'login' => 'パスワードが違います',
                ]);
            }
        } else {
            // 一般ユーザー：4桁PIN
            if (!preg_match('/^\d{4}$/', $pass)) {
                return back()->withErrors([
                    'login' => '暗証番号は4桁の数字で入力してください',
                ]);
            }
        }

        // ===============================
        // ログイン成功
        // ===============================
        Auth::login($user);
        $request->session()->regenerate();

        // ===============================
        // 画面遷移
        // ===============================
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        if (!$user->is_approved) {
            return redirect()->route('waiting');
        }

        return redirect()->route('threads.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
