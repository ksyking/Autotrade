<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();

            $table->string('title', 150);
            $table->text('description')->nullable();

            $table->string('color_ext', 40)->nullable();
            $table->string('color_int', 40)->nullable();

            $table->unsignedInteger('mileage')->default(0);
            $table->decimal('price', 10, 2);

            $table->string('city', 80)->nullable();
            $table->string('state', 2)->nullable(); // US state code

            $table->unsignedTinyInteger('condition_grade')->nullable(); // 1–5
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['is_active', 'price', 'mileage']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
