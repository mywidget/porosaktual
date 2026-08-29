<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            $table->string('url')->nullable();
            $table->string('referer')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->boolean('is_unique')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};