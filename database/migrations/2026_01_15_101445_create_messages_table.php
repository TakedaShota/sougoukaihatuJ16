<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // ★ここを修正しました★
            // matches ではなく、interest_requests テーブルの id に紐付けます
            // カラム名も分かりやすく interest_request_id に変更します
            $table->foreignId('interest_request_id')
                  ->constrained('interest_requests')
                  ->onDelete('cascade');

            // 送信者
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // メッセージ本文
            $table->text('body');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};