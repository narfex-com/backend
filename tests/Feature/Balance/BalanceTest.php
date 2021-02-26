<?php

namespace Tests\Feature\Balance;

use App\Models\Balance;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();

        Sanctum::actingAs($user);
        $response = $this->get(route('balances.index'));

        $response->assertStatus(200);
    }
}
