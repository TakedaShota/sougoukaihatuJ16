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
        Schema::create('interest_requests', function (Blueprint $table) {
            $table->id();

            // どのスレッドへの申請か
            $table->foreignId('thread_id')
                ->constrained()
                ->cascadeOnDelete();

            // 興味ありを押した人
            $table->foreignId('from_user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // 投稿者（スレッド作成者）
            $table->foreignId('to_user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // 状態：pending / approved / rejected
            $table->string('status')->default('pending');

            $table->timestamps();

            // 同じ人が同じスレッドに複数回送れないようにする
            $table->unique(['thread_id', 'from_user_id']);

            // 一覧表示を速くするためのインデックス
            $table->index(['to_user_id', 'status']);
            $table->index(['from_user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_requests');
    }
};
