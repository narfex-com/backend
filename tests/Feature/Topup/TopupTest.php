<?php

namespace Tests\Feature\Topup;

use App\Models\Currency;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TopupTest extends TestCase
{
    use RefreshDatabase;

    public function test_topup_create()
    {
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();

        Sanctum::actingAs($user);
        $currencyId = Currency::whereCode('idr')->available()->first()->id;
        $amount = 200000;

        $response = $this->post(route('topups.create'), [
            'currency_id' => $currencyId,
            'amount' => $amount
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('topups', [
            'amount' => $amount
        ]);

    }
}
