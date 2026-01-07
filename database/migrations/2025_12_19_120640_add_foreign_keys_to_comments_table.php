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
        Schema::table('comments', function (Blueprint $table) {
            // comments.thread_id → threads.id
            $table->foreign('thread_id')
                  ->references('id')
                  ->on('threads')
                  ->cascadeOnDelete();

            // comments.user_id → users.id
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();

            // comments.parent_id → comments.id（自己参照）
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('comments')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['thread_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['parent_id']);
        });
    }
};
