<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->text('search_text')->nullable()->after('description');
            $table->string('primary_photo_url', 2048)->nullable()->after('search_text');
            $table->string('primary_photo_key', 1024)->nullable()->after('primary_photo_url');
        });

        // Optional: helps if you later switch to FULLTEXT search (MariaDB supports FULLTEXT on InnoDB)
        // If this migration errors on your setup, comment it out.
        // Schema::table('listings', fn (Blueprint $table) => $table->fullText('search_text'));
    }

    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            // If you added fullText, Laravel will auto-drop it with column drop on many DBs,
            // but if it complains, you may need to drop index explicitly.
            $table->dropColumn(['search_text', 'primary_photo_url', 'primary_photo_key']);
        });
    }
};
