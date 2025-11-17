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
        $seller3 = DB::table('users')->insertGetId([
            'name' => 'Jacob Seller',
            'display_name' => 'Jacob',
            'role' => 'seller',
            'email' => 'jacob@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $seller4 = DB::table('users')->insertGetId([
            'name' => 'Kylie Seller',
            'display_name' => 'Kylie',
            'role' => 'seller',
            'email' => 'kylie@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $seller5 = DB::table('users')->insertGetId([
            'name' => 'Eve Seller',
            'display_name' => 'Eve',
            'role' => 'seller',
            'email' => 'eve@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $seller6 = DB::table('users')->insertGetId([
            'name' => 'Mike Seller',
            'display_name' => 'Mike',
            'role' => 'seller',
            'email' => 'mike@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $seller7 = DB::table('users')->insertGetId([
            'name' => 'Sara Seller',
            'display_name' => 'Sara',
            'role' => 'seller',
            'email' => 'sara@example.com',
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
            'make' => 'Ford', 'model' => 'F-150', 'trim' => 'Super Cab', 'year' => 2020,
            'body_type' => 'Truck', 'drivetrain' => '4WD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $v4 = DB::table('vehicles')->insertGetId([
            'make' => 'Ford', 'model' => 'Focus', 'trim' => 'SE', 'year' => 2013,
            'body_type' => 'Hatchaback', 'drivetrain' => 'FWD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $v5 = DB::table('vehicles')->insertGetId([
            'make' => 'Ford', 'model' => 'Focus', 'trim' => 'ST', 'year' => 2013,
            'body_type' => 'Hatchaback', 'drivetrain' => 'FWD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $v6 = DB::table('vehicles')->insertGetId([
            'make' => 'Honda', 'model' => 'Civic', 'trim' => 'LX', 'year' => 2017,
            'body_type' => 'Hatchback', 'drivetrain' => 'FWD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $v7 = DB::table('vehicles')->insertGetId([
            'make' => 'Toyota', 'model' => 'Prius', 'trim' => null, 'year' => 2012,
            'body_type' => 'Htachback', 'drivetrain' => 'FWD', 'fuel_type' => 'Plug-in Hybrid', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $v8 = DB::table('vehicles')->insertGetId([
            'make' => 'Ford', 'model' => 'F-150', 'trim' => 'SuperCrew Cab', 'year' => 2019,
            'body_type' => 'Truck', 'drivetrain' => 'RWD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $v9 = DB::table('vehicles')->insertGetId([
            'make' => 'Honda', 'model' => 'Odyssey', 'trim' => null, 'year' => 2014,
            'body_type' => 'Minivan', 'drivetrain' => 'FWD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $v10 = DB::table('vehicles')->insertGetId([
            'make' => 'Ford', 'model' => 'Flex', 'trim' => null, 'year' => 2015,
            'body_type' => 'Minivan', 'drivetrain' => 'FWD', 'fuel_type' => 'Gas', 'transmission' => 'Automatic',
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
            [
                'seller_id' => $seller4, 'vehicle_id' => $v4,
                'title' => 'Great Condition Focus SE', 'description' => 'Effective and simple car',
                'color_ext' => 'Red', 'color_int' => 'Black and Tan',
                'mileage' => 10200, 'price' => 5499.00,
                'city' => 'Santa Clarita', 'state' => 'CA',
                'condition_grade' => 4, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'seller_id' => $seller4, 'vehicle_id' => $v5,
                'title' => 'Repaired and Maintained Focus ST', 'description' => 'Fun to drive without scrificing much utility',
                'color_ext' => 'Yellow', 'color_int' => 'Black',
                'mileage' => 100500, 'price' => 8995.00,
                'city' => 'Santa Clarita', 'state' => 'CA',
                'condition_grade' => 4, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'seller_id' => $seller3, 'vehicle_id' => $v6,
                'title' => '2017 Honda Civic', 'description' => 'Fuel efficient and reliable.',
                'color_ext' => 'Gray', 'color_int' => 'Black',
                'mileage' => 45000, 'price' => 13700.00,
                'city' => 'Austin', 'state' => 'TX',
                'condition_grade' => 4, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'seller_id' => $seller3, 'vehicle_id' => $v7,
                'title' => 'used Prius', 'description' => 'Great fuel economy and trunk space.',
                'color_ext' => 'Green', 'color_int' => 'Gray',
                'mileage' => 75000, 'price' => 4500.00,
                'city' => 'San Diego', 'state' => 'CA',
                'condition_grade' => 3, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'seller_id' => $seller5, 'vehicle_id' => $v8,
                'title' => 'moodern F-150', 'description' => 'Strong truck in excellent condition.',
                'color_ext' => 'Black', 'color_int' => 'White',
                'mileage' => 30000, 'price' => 28999.00,
                'city' => 'Dallas', 'state' => 'TX',
                'condition_grade' => 5, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'seller_id' => $seller6, 'vehicle_id' => $v9,
                'title' => 'Honda Odyssey Mini Van', 'description' => 'Spacious and comfortable minivan.',
                'color_ext' => 'White', 'color_int' => 'Gray',
                'mileage' => 60000, 'price' => 15999.00,
                'city' => 'Dallas', 'state' => 'TX',
                'condition_grade' => 4, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'seller_id' => $seller7, 'vehicle_id' => $v10,
                'title' => 'Ford Flex family van', 'description' => 'Suv slash minivan.',
                'color_ext' => 'Silver', 'color_int' => 'Black',
                'mileage' => 95000, 'price' => 7999.00,
                'city' => 'Seattle', 'state' => 'WA',
                'condition_grade' => 4, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
