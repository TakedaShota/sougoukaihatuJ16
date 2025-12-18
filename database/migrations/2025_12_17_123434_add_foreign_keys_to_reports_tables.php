<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });

        Schema::table('thread_reports', function (Blueprint $table) {
            $table->foreign('thread_id')
                  ->references('id')
                  ->on('threads')
                  ->cascadeOnDelete();

            $table->foreign('report_id')
                  ->references('id')
                  ->on('reports')
                  ->cascadeOnDelete();
        });

        Schema::table('comment_reports', function (Blueprint $table) {
            $table->foreign('comment_id')
                  ->references('id')
                  ->on('comments')
                  ->cascadeOnDelete();

            $table->foreign('report_id')
                  ->references('id')
                  ->on('reports')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('comment_reports', function (Blueprint $table) {
            $table->dropForeign(['comment_id']);
            $table->dropForeign(['report_id']);
        });

        Schema::table('thread_reports', function (Blueprint $table) {
            $table->dropForeign(['thread_id']);
            $table->dropForeign(['report_id']);
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
