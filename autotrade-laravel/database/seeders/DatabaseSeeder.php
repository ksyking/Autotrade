<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users (for seller_id FK)
        $seller1 = DB::table('users')->insertGetId([
            'name' => 'Alice Seller',
            'display_name' => 'Alice',
            'role' => 'seller',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $seller2 = DB::table('users')->insertGetId([
            'name' => 'Bob Seller',
            'display_name' => 'Bob',
            'role' => 'seller',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Vehicles
        $v1 = DB::table('vehicles')->insertGetId([
            'make' => 'Honda', 'model' => 'CR-V', 'trim' => null, 'year' => 2021,
            'body_type' => 'SUV', 'drivetrain' => 'AWD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $v2 = DB::table('vehicles')->insertGetId([
            'make' => 'Toyota', 'model' => 'Camry', 'trim' => null, 'year' => 2019,
            'body_type' => 'Sedan', 'drivetrain' => 'FWD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $v3 = DB::table('vehicles')->insertGetId([
            'make' => 'Ford', 'model' => 'F-150', 'trim' => null, 'year' => 2020,
            'body_type' => 'Truck', 'drivetrain' => '4WD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // Listings
        DB::table('listings')->insert([
            [
                'seller_id' => $seller1, 'vehicle_id' => $v1,
                'title' => 'Well-maintained CR-V', 'description' => 'Clean title, one owner.',
                'color_ext' => 'Blue', 'color_int' => 'Black',
                'mileage' => 32000, 'price' => 25999.00,
                'city' => 'Cincinnati', 'state' => 'OH',
                'condition_grade' => 4, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'seller_id' => $seller1, 'vehicle_id' => $v2,
                'title' => 'Reliable Camry', 'description' => 'Great commuter car.',
                'color_ext' => 'Silver', 'color_int' => 'Gray',
                'mileage' => 58000, 'price' => 16999.00,
                'city' => 'Columbus', 'state' => 'OH',
                'condition_grade' => 3, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'seller_id' => $seller2, 'vehicle_id' => $v3,
                'title' => 'F-150 4x4', 'description' => 'Tows like a champ.',
                'color_ext' => 'White', 'color_int' => 'Black',
                'mileage' => 44000, 'price' => 33999.00,
                'city' => 'Lexington', 'state' => 'KY',
                'condition_grade' => 4, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
