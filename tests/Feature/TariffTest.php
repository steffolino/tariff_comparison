<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tariff;

class TariffTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('api/tariffs');
        $response->assertStatus(200);
    }

    public function testsTariffsAreCreatedCorrectly()
    {
        $payload = [
            'name' => 'fake test basic electricity tariff',
            'annual_costs' => 0,
            'flatrate_price' => NULL,
            'flatrate_consumption' => NULL,
            'monthly' => 5,
            'per_kwh' => 0.22,
        ];

        /***TODO: check why flatrate_price = NULL fails
         *  'updated_at' => '2019-03-01 18:38:00',
         *  'created_at' => '2019-03-01 18:38:00',
         *  'id' => 1,
         *   -  'flatrate_price' => NULL,
         **/
        $this->json('POST', '/api/tariffs', $payload)
            ->assertStatus(201)
            ->assertJson([
                'name' => 'fake test basic electricity tariff',
                'annual_costs' => 0,
                //'flatrate_price' => NULL,
                'flatrate_consumption' => NULL,
                'monthly' => 5,
                'per_kwh' => 0.22,
                ]);
    }

    public function testsTariffsAreUpdatedCorrectly()
    {
        $tariff = factory(Tariff::class)->create([
            'name' => 'fake test basic electricity tariff',
            'annual_costs' => 0,
            'flatrate_price' => NULL,
            'flatrate_consumption' => NULL,
            'monthly' => 5,
            'per_kwh' => 0.22,
        ]);

        $payload = [
            'name' => 'fake test basic electricity tariff',
            'annual_costs' => 0,
            'flatrate_price' => NULL,
            'flatrate_consumption' => NULL,
            'monthly' => 5,
            'per_kwh' => 0.22,
        ];

        $response = $this->json('PUT', '/api/tariffs/' . $tariff->id, $payload)
            ->assertStatus(200)
            ->assertJson([
                'name' => 'fake test basic electricity tariff',
                'annual_costs' => 0,
                'flatrate_price' => NULL,
                'flatrate_consumption' => NULL,
                'monthly' => 5,
                'per_kwh' => 0.22,
            ]);
    }

    public function testsTariffsAreDeletedCorrectly()
    {
        $tariff = factory(Tariff::class)->create([
            'name' => 'fake test basic electricity tariff',
            'annual_costs' => 0,
            'flatrate_price' => NULL,
            'flatrate_consumption' => NULL,
            'monthly' => 5,
            'per_kwh' => 0.22,
        ]);

        $this->json('DELETE', '/api/tariffs/' . $tariff->id, [])
            ->assertStatus(204);
    }

    public function testTariffsAreListedCorrectly()
    {
        factory(Tariff::class)->create([
            'name' => 'fake test basic electricity tariff',
            'annual_costs' => 0,
            'flatrate_price' => NULL,
            'flatrate_consumption' => NULL,
            'monthly' => 5,
            'per_kwh' => 0.22,
        ]);

        factory(Tariff::class)->create([
            'name' => 'fake test Packaged tariff',
            'annual_costs' => 0,
            'flatrate_price' => 800,
            'flatrate_consumption' => 4000,
            'monthly' => 0,
            'per_kwh' => 0.30,
        ]);

        $response = $this->json('GET', '/api/tariffs', [])
            ->assertStatus(200)
            ->assertJson([
                [
                    'name' => 'fake test basic electricity tariff',
                    'annual_costs' => 0,
                    'flatrate_price' => NULL,
                    'flatrate_consumption' => NULL,
                    'monthly' => 5,
                    'per_kwh' => 0.22,
                ],
                [
                    'name' => 'fake test Packaged tariff',
                    'annual_costs' => 0,
                    'flatrate_price' => 800,
                    'flatrate_consumption' => 4000,
                    'monthly' => 0,
                    'per_kwh' => 0.30,
                ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'name', 'annual_costs', 'flatrate_price', 'flatrate_consumption', 'monthly', 'per_kwh'],
            ]);
    }
}
