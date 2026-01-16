<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    
    public function show(User $user)
    {
        // 相手のプロフィール画面を表示
        return view('profile.show', ['user' => $user]);
    }
    // 編集画面を表示
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    // 更新処理
    public function update(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'introduction' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048', // 2MBまで
        ]);

        $user = auth()->user();

        // データの更新
        $user->name = $request->name;
        $user->introduction = $request->introduction;

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            // 古い画像があれば削除
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // 画像を保存
            $path = $request->file('image')->store('profiles', 'public');
            $user->image = $path;
        }

        $user->save();

        // ▼ 【ここを変更しました】
        // 保存完了後、募集一覧ページ（threads.index）へ移動するように変更
        return redirect()->route('threads.index')->with('success', 'プロフィールを更新しました！');
    }
}