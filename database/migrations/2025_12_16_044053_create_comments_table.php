<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // どのスレッドのコメントか
            $table->foreignId('thread_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // 誰が書いたコメントか
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // コメント本文
            $table->text('body');

            // 返信用（親コメント）
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('comments')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
