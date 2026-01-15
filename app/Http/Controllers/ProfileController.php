<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * プロフィール更新
     * 保存後はダッシュボードへ遷移
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $validated = $request->validate([
            'bio'   => ['nullable', 'string', 'max:1000'],
            'hobby' => ['nullable', 'string', 'max:255'],
            'age'   => ['nullable', 'integer', 'min:0', 'max:120'],
            'icon'  => ['nullable', 'image', 'max:2048'],
        ]);

        // アイコン保存
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated['icon'] = $path;
        }

        // DB更新
        $user->update($validated);

        // ✅ 保存後は必ずダッシュボードへ
        return redirect()->route('dashboard');
    }
}
