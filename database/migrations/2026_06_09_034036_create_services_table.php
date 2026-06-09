<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->default('wrench-screwdriver');
            $table->string('summary');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->json('features')->nullable();
            $table->json('faqs')->nullable();
            $table->unsignedInteger('price_from')->nullable();
            $table->unsignedInteger('duration_min')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
