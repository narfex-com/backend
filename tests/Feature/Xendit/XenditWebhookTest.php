<?php

namespace Tests\Feature\Xendit;

use App\Models\Balance;
use App\Models\Topup;
use App\Models\User;
use App\Models\Withdrawal;
use App\Services\Topup\Adapters\Xendit;
use App\Services\Withdrawal\Xendit\DisbursementWebhookData;
use Database\Seeders\CurrencySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class XenditWebhookTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_invoice()
    {
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();
        $amount = 200000;
        $balance = Balance::whereUserId($user->id)
            ->whereHas('currency', fn($query) => $query->where('code', 'idr'))
            ->first();
        $invoice = Topup::factory()->create([
            'user_id' => $user->id,
            'balance_id' => $balance->id,
            'currency_id' => $balance->currency_id,
            'amount' => 200000,
            'status_id' => Topup::STATUS_CREATED,
            'topup_method' => 'xendit',
        ]);
        $response = $this->post(route('webhooks.xendit.invoice'), [
            'external_id' => $invoice->id,
            'status' => Xendit::STATUS_PAID
        ], [
            'x-callback-token' => config('payments.xendit.verification_token')
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('topups', [
            'id' => $invoice->id,
            'amount' => $amount
        ]);
        $this->assertDatabaseHas('balances', [
            'id' => $balance->id,
            'amount' => $balance->amount + $amount
        ]);
    }

    public function test_disbursement()
    {
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();
        $amount = 200000;
        $balance = Balance::whereUserId($user->id)
            ->whereHas('currency', fn($query) => $query->where('code', 'idr'))
            ->first();
        $withdrawal = Withdrawal::factory()->create([
            'user_id' => $user->id,
            'currency_id' => $balance->currency_id,
            'balance_id' => $balance->id,
            'withdrawal_method' => 'xendit',
            'amount' => $amount,
            'status_id' => Withdrawal::STATUS_PENDING,
        ]);

        $response = $this->post(route('webhooks.xendit.disbursement'), [
            'external_id' => (string) $withdrawal->id,
            'status' => DisbursementWebhookData::STATUS_COMPLETED
        ], [
            'x-callback-token' => config('payments.xendit.verification_token')
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawal->id,
            'status_id' => Withdrawal::STATUS_SUCCESSFUL
        ]);
    }
}
