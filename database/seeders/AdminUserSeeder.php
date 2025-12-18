<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 管理者ユーザー作成（電話番号ユニークにする）
        User::create([
            'name' => '管理者',
            'phone' => '09087654321',   // テストユーザーと被らない番号
            'room_number' => '000',
            'is_admin' => 1,
            'is_approved' => 1,
            'password' => bcrypt('password'),
        ]);
    }
}
