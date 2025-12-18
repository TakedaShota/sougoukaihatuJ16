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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // どのスレッドのコメントか（外部キーは後で張る）
            $table->unsignedBigInteger('thread_id');

            // 誰が書いたコメントか（外部キーは後で張る）
            $table->unsignedBigInteger('user_id');

            // 返信用（親コメント）
            $table->unsignedBigInteger('parent_id')->nullable();

            // コメント本文
            $table->text('body');

            $table->timestamps();

            // ※ ここでは foreign key を一切定義しない
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
