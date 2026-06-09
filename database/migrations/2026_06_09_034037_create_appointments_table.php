<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('vehicle_make');
            $table->string('vehicle_model');
            $table->unsignedSmallInteger('vehicle_year')->nullable();
            $table->string('plate')->nullable();
            $table->date('preferred_date');
            $table->string('preferred_time');
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index(['preferred_date', 'preferred_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
