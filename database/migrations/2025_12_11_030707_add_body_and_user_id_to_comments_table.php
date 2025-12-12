<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->text('body')->after('id');
            $table->unsignedBigInteger('user_id')->nullable()->after('thread_id');

            // 外部キー
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // 外部キーも削除
            $table->dropColumn('body');
            $table->dropColumn('user_id');
        });
    }
};
