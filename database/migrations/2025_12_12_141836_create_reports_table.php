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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // 通報した人
            $table->unsignedBigInteger('thread_id')->nullable(); // 通報対象 → 投稿
            $table->unsignedBigInteger('comment_id')->nullable(); // 通報対象 → コメント
            $table->text('reason')->nullable(); // 理由（任意）
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
