<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // テストユーザー作成
        User::factory()->create([
            'name' => 'Test User',
            'phone' => '09012345678',   // 固定電話番号でもOK
            'password' => bcrypt('password'),
        ]);

        // 管理者アカウント作成
        $this->call(AdminUserSeeder::class);
    }
}
