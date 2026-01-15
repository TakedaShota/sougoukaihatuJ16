<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * 認可（ログイン済みならOK）
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            // =========================
            // 基本情報（Breeze 標準）
            // =========================
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // =========================
            // プロフィール追加項目
            // =========================

            // 表示名（ニックネーム）
            'display_name' => ['nullable', 'string', 'max:255'],

            // アイコン画像（アップロード）
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // 自己紹介
            'bio' => ['nullable', 'string', 'max:500'],

            // 趣味
            'hobby' => ['nullable', 'string', 'max:255'],

            // 年齢
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],

            // 性別
            'gender' => ['nullable', 'string', 'max:10'],

            // 居住地（団地名など）
            'residence' => ['nullable', 'string', 'max:100'],
        ];
    }
}
