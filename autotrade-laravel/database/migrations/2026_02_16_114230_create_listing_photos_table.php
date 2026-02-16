<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('listing_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listing_id');
            $table->string('photo_url', 2048);
            $table->string('photo_key', 1024);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->foreign('listing_id')
                ->references('id')->on('listings')
                ->onDelete('cascade');

            $table->index('listing_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_photos');
    }
};
