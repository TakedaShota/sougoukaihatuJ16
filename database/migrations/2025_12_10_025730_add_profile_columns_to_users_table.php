<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('icon')->nullable();      // アイコン画像
            $table->text('bio')->nullable();         // 自己紹介
            $table->string('hobby')->nullable();     // 趣味
            $table->integer('age')->nullable();      // 年齢
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['icon', 'bio', 'hobby', 'age']);
        });
    }
};
