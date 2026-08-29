<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('slot_id')->constrained('advertisement_slots')->cascadeOnDelete();
            $table->string('title');
            $table->enum('type', ['adsense', 'banner', 'html_script', 'internal']);
            $table->string('banner_image')->nullable();
            $table->longText('html_code')->nullable();
            $table->string('url')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('impressions_count')->default(0);
            $table->unsignedBigInteger('clicks_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};