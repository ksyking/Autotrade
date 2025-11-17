<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class DemoVehicleSeeder extends Seeder
    {
        public function run(): void
        {
            $makes = [
                'Toyota' => ['Camry','Corolla','RAV4','Highlander'],
                'Honda' => ['Civic','Accord','CR-V','Pilot'],
                'Ford' => ['F-150','Escape','Explorer','Fusion'],
                'Chevrolet' => ['Malibu','Equinox','Silverado 1500','Traverse'],
                'Nissan' => ['Altima','Sentra','Rogue','Murano'],
                'Subaru' => ['Outback','Forester','Impreza','Crosstrek'],
                'Hyundai' => ['Elantra','Sonata','Tucson','Santa Fe'],
                'Kia' => ['Soul','Optima','Sportage','Sorento'],
                'Mazda' => ['Mazda3','Mazda6','CX-5','CX-9'],
                'Volkswagen' => ['Jetta','Passat','Tiguan','Golf'],
                'BMW' => ['3 Series','5 Series','X3','X5'],
                'Audi' => ['A4','A6','Q5','Q7'],
                'Mercedes-Benz' => ['C300','E350','GLA250','GLC300'],
                'Lexus' => ['IS 300','ES 350','RX 350','NX 300'],
            ];

            $bodyTypes = ['Sedan','SUV','Truck','Wagon','Hatchback'];
            $trans     = ['Automatic','Manual','CVT'];
            $colors    = ['Black','White','Gray','Blue','Red','Silver'];
            $states    = ['CA','NV','AZ','TX','WA','OR','UT'];

            $rows = [];
            $now  = now();

            for ($i = 0; $i < 50; $i++) {
                $make = array_keys($makes)[$i % count($makes)];
                $modelList = $makes[$make];
                $model = $modelList[$i % count($modelList)];

                $rows[] = [
                    'make'         => $make,
                    'model'        => $model,
                    'year'         => 2014 + ($i % 12),
                    'price'        => 12000 + ($i * 500),
                    'mileage'      => 25000 + ($i * 800),
                    'body_type'    => $bodyTypes[$i % count($bodyTypes)],
                    'transmission' => $trans[$i % count($trans)],
                    'color'        => $colors[$i % count($colors)],
                    'location'     => $states[$i % count($states)],
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }

            DB::table('vehicles')->insert($rows);
        }
    }