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
        Schema::create('faceit_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TelegramUser::class);
            $table->string("nick");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faceit_trackings');
    }
};
