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
        Schema::create('user_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TelegramUser::class);
            $table->foreignIdFor(\App\Models\Chat::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chats');
    }
};
