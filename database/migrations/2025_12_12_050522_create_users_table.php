<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');               // 名前
            $table->string('phone', 15)->unique(); // 電話番号
            $table->string('room_number')->nullable(); // 部屋番号
            $table->text('interests')->nullable(); // 趣味・紹介文
            $table->string('avatar')->nullable();  // アバター
            $table->string('password');           // パスワード

            $table->boolean('is_admin')->default(0);     // 管理者フラグ
            $table->boolean('is_approved')->default(0);  // 承認フラグ

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
