<?php

namespace Tests\Feature\Transaction;

use App\Models\Exchange;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_transactions()
    {
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();
        $balances = $user->balances;
        $fromBalance = $balances->where('currency.code', 'btc')->first();
        $toBalance = $balances->where('currency.code', 'idr')->first();

        Exchange::factory()->count(20)->create([
            'from_balance_id' => $fromBalance->id,
            'to_balance_id' => $toBalance->id,
            'from_amount' => 1.000033333333333,
            'to_amount' => 100000.12345,
            'from_currency_id' => $fromBalance->currency_id,
            'to_currency_id' => $toBalance->currency_id,
            'user_id' => $user->id,
            'rate' => rand(0, 1000000),
            'status_id' => 1
        ]);

        Sanctum::actingAs($user);

        $response = $this->get(route('transactions.index'));

        $response->assertStatus(200);
    }
}
