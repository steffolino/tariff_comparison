<?php

use Illuminate\Database\Seeder;
use App\Tariff;

class TariffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Tariff::truncate();

        $faker = \Faker\Factory::create();

        //Two assignment tariffs
        Tariff::create([
            'name' => 'basic electricity tariff',
            'annual_costs' => 0.00,
            'flatrate_price' => NULL,
            'flatrate_consumption' => NULL,
            'monthly' => 5.00,
            'per_kwh' => 0.22,
            ]);

        Tariff::create([
                'name' => 'Packaged tariff',
                'annual_costs' => 0.00,
                'flatrate_price' => 800,
                'flatrate_consumption' => 4000,
                'monthly' => 0.00,
                'per_kwh' => 0.30,
            ]);

        // And now, let's create a few tariffs in our database:
        /**
         * TODO: enable below for more random data
         */
        /**
        for ($i = 0; $i < 30; $i++) {

            $flatrate = $faker->randomDigit();

            if($flatrate != NULL) {
                Tariff::create([
                    'name' => $faker->text(20),
                    'annual_costs' => 0.00,
                    'flatrate_price' => $faker->numberBetween(750, 1500),
                    'flatrate_consumption' => $faker->numberBetween(3000, 4000),
                    'monthly' => 0.00,
                    'per_kwh' => $faker->randomFloat(2, 0, 1),
                ]);
            } else {
                Tariff::create([
                    'name' => $faker->text(20),
                    'annual_costs' => 0.00,
                    'flatrate_price' => NULL,
                    'flatrate_consumption' => NULL,
                    'monthly' => $faker->randomFloat(2, 0,20),
                    'per_kwh' => $faker->randomFloat(2, 0, 1),
                ]);
            }
        }
         **/
    }
}
