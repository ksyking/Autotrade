<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run ALL demo data from one clean seeder
        $this->call([
            DemoDataSeeder::class,
        ]);
    }
}