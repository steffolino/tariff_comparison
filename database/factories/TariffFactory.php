<?php

use Faker\Generator as Faker;

$factory->define(App\Tariff::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'annual_costs' => 0.00,
        'flatrate_price' => $faker->numberBetween(750, 1500),
        'flatrate_consumption' => $faker->numberBetween(3000, 4000),
        'monthly' => 0.00,
        'per_kwh' => $faker->randomFloat(2, 0, 1),
    ];
});
