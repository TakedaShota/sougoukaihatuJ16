<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 登録フォーム表示
    public function show()
    {
        return view('auth.register');
    }

    // 登録処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'room_number' => 'required|string|max:50',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'room_number' => $request->room_number,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
            'is_approved' => 0,
        ]);

        return redirect()->route('login')
            ->with('message', '登録完了。管理者の承認をお待ちください。');
    }
}
