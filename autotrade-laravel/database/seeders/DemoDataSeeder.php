<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------
        // 1) Seed SELLER USERS
        // -----------------------------
        $sellerIds = [];

        for ($i = 1; $i <= 25; $i++) {
            $sellerIds[] = DB::table('users')->insertGetId([
                'name'             => "Seller {$i}",
                'display_name'     => "Seller {$i}",
                'role'             => 'seller',
                'email'            => "seller{$i}@example.com",
                'email_verified_at'=> now(),
                'password'         => Hash::make('password'),
                'remember_token'   => Str::random(10),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        // -----------------------------
        // 2) Seed VEHICLES (≈300)
        // -----------------------------
        $makeModels = [
            'Honda'    => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Fit'],
            'Toyota'   => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Tacoma'],
            'Ford'     => ['F-150', 'Escape', 'Explorer', 'Fusion', 'Focus'],
            'Chevrolet'=> ['Silverado 1500', 'Equinox', 'Malibu', 'Tahoe', 'Camaro'],
            'Nissan'   => ['Altima', 'Sentra', 'Rogue', 'Murano', 'Frontier'],
            'Subaru'   => ['Outback', 'Forester', 'Crosstrek', 'Impreza'],
            'Hyundai'  => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe'],
            'Kia'      => ['Soul', 'Sportage', 'Sorento', 'Optima'],
        ];

        $bodyTypes     = ['Sedan', 'SUV', 'Truck', 'Coupe', 'Hatchback', 'Wagon'];
        $drivetrains   = ['FWD', 'RWD', 'AWD', '4WD'];
        $fuels         = ['Gas', 'Diesel', 'Hybrid', 'Electric'];
        $transmissions = ['Automatic', 'Manual', 'CVT'];

        $vehicleIds = [];

        for ($i = 0; $i < 300; $i++) {
            $make       = array_rand($makeModels);
            $model      = $makeModels[$make][array_rand($makeModels[$make])];
            $year       = rand(2010, 2024);
            $bodyType   = $bodyTypes[array_rand($bodyTypes)];
            $drivetrain = $drivetrains[array_rand($drivetrains)];
            $fuel       = $fuels[array_rand($fuels)];
            $trans      = $transmissions[array_rand($transmissions)];

            $vehicleIds[] = DB::table('vehicles')->insertGetId([
                'make'         => $make,
                'model'        => $model,
                'trim'         => null,
                'year'         => $year,
                'body_type'    => $bodyType,
                'drivetrain'   => $drivetrain,
                'fuel_type'    => $fuel,
                'transmission' => $trans,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // -----------------------------
        // 3) Seed LISTINGS (≈150)
        // -----------------------------
        $colors   = ['Black', 'White', 'Silver', 'Gray', 'Blue', 'Red', 'Green', 'Brown'];
        $states   = ['CA', 'TX', 'NY', 'FL', 'OH', 'WA', 'CO', 'IL', 'GA', 'NC'];
        $citiesByState = [
            'CA' => ['Los Angeles', 'San Diego', 'San Jose', 'Sacramento'],
            'TX' => ['Houston', 'Dallas', 'Austin', 'San Antonio'],
            'NY' => ['New York', 'Buffalo', 'Rochester', 'Albany'],
            'FL' => ['Miami', 'Orlando', 'Tampa', 'Jacksonville'],
            'OH' => ['Columbus', 'Cleveland', 'Cincinnati'],
            'WA' => ['Seattle', 'Tacoma', 'Spokane'],
            'CO' => ['Denver', 'Boulder', 'Colorado Springs'],
            'IL' => ['Chicago', 'Naperville', 'Springfield'],
            'GA' => ['Atlanta', 'Savannah', 'Augusta'],
            'NC' => ['Charlotte', 'Raleigh', 'Durham'],
        ];

        $titles = [
            'Low mileage',
            'One owner',
            'Clean title',
            'Certified',
            'Great commuter',
            'Family SUV',
            'Work truck',
            'Sporty and fun',
            'Gas saver',
            'Fully loaded',
        ];

        $listings = [];

        for ($i = 0; $i < 150; $i++) {
            $vehicleId = $vehicleIds[array_rand($vehicleIds)];
            $sellerId  = $sellerIds[array_rand($sellerIds)];

            $extColor = $colors[array_rand($colors)];
            $intColor = $colors[array_rand($colors)];
            $mileage  = rand(15_000, 140_000);
            $price    = rand(8_000, 55_000);

            $state        = $states[array_rand($states)];
            $cityOptions  = $citiesByState[$state] ?? ['Springfield', 'Fairview', 'Riverton'];
            $city         = $cityOptions[array_rand($cityOptions)];

            $titleBase = $titles[array_rand($titles)];
            $title     = "{$titleBase} {$city}";

            $listings[] = [
                'seller_id'        => $sellerId,
                'vehicle_id'       => $vehicleId,
                'title'            => $title,
                'description'      => 'Demo listing seeded for presentation. Not real inventory.',
                'color_ext'        => $extColor,
                'color_int'        => $intColor,
                'mileage'          => $mileage,
                'price'            => $price,
                'city'             => $city,
                'state'            => $state,
                'condition_grade'  => rand(2, 5),
                'is_active'        => true,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }

        DB::table('listings')->insert($listings);
    }
}
