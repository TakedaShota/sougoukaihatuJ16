<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 新規登録画面
    public function show()
    {
        return view('auth.register');
    }

    // 新規登録処理
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => ['required','digits:11','unique:users,phone'], // 11桁固定
            'room_number' => ['required','digits:3'],                        // 3桁固定
            'password'    => 'required|confirmed|min:8',
        ]);

        User::create([
            'name'        => $request->name,
            'phone'       => $request->phone,
            'room_number' => $request->room_number,
            'password'    => Hash::make($request->password),
            'is_admin'    => 0,
            'is_approved' => 0,
        ]);

        return redirect()->route('login')
            ->with('message', '登録完了。管理者の承認をお待ちください。');
    }
}
