<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Single entry point that runs all demo data
        $this->call([
            DemoDataSeeder::class,
        ]);
    }
}
