<?php

namespace Tests\Feature\Exchange;

use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserExchangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_exchange()
    {
        $this->seed(CurrencySeeder::class);
        /** @var User $user */
        $user = User::factory()->create();

        $balances = $user->balances;
        $fromBalance = $balances->where('currency.code', 'btc')->first();
        $toBalance = $balances->where('currency.code', 'idr')->first();

        Sanctum::actingAs($user);

        $requestBody = [
            'from_balance_id' => $fromBalance->id,
            'to_balance_id' => $toBalance->id,
            'from_amount' => 0.1,
            'to_amount' => 0,
            'is_from_amount' => true
        ];

        $response = $this->post(route('exchanges.create'), $requestBody);

        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'from_balance_id' => $fromBalance->id,
            'to_balance_id' => $toBalance->id,
        ]);
        $this->assertDatabaseHas('exchanges', [
            'user_id' => $user->id,
            'from_balance_id' => $fromBalance->id,
            'to_balance_id' => $toBalance->id,
        ]);

        $this->assertDatabaseHas('balances', [
            'id' => $fromBalance->id,
            'amount' => 1.9
        ]);
    }

    public function test_insufficient_funds()
    {
        $this->seed(CurrencySeeder::class);
        /** @var User $user */
        $user = User::factory()->create();

        $balances = $user->balances;
        $fromBalance = $balances->where('currency.code', 'btc')->first();
        $toBalance = $balances->where('currency.code', 'idr')->first();

        Sanctum::actingAs($user);

        $requestBody = [
            'from_balance_id' => $fromBalance->id,
            'to_balance_id' => $toBalance->id,
            'from_amount' => 3,
            'to_amount' => 0,
            'is_from_amount' => true
        ];

        $response = $this->post(route('exchanges.create'), $requestBody);

        $response->assertStatus(400);

        $this->assertDatabaseMissing('transactions', [
            'user_id' => $user->id,
            'from_balance_id' => $fromBalance->id,
            'to_balance_id' => $toBalance->id,
        ]);
        $this->assertDatabaseMissing('exchanges', [
            'user_id' => $user->id,
            'from_balance_id' => $fromBalance->id,
            'to_balance_id' => $toBalance->id,
        ]);
    }
}
