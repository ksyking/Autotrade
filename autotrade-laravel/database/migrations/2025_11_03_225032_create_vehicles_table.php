<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('make', 80);
            $table->string('model', 80);
            $table->string('trim', 80)->nullable();
            $table->unsignedSmallInteger('year');
            $table->string('body_type', 40);      // SUV, Truck, Sedan, etc.
            $table->string('drivetrain', 20);     // FWD, RWD, AWD, 4WD
            $table->string('fuel_type', 20)->nullable();     // Gas, Diesel, Hybrid, EV
            $table->string('transmission', 20)->nullable();  // Automatic, Manual
            $table->timestamps();

            $table->index(['make','model','year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
