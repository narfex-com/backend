<?php

namespace Tests\Feature\Withdrawal;

use App\Exceptions\Withdrawal\WithdrawalCannotBeProcessedException;
use App\Models\Balance;
use App\Models\User;
use App\Models\Withdrawal;
use App\Services\Withdrawal\Adapters\IdrAdapter;
use App\Services\Withdrawal\WithdrawalService;
use App\Services\Withdrawal\Xendit\DisbursementWebhookData;
use Database\Seeders\CurrencySeeder;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WithdrawalTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_withdrawal()
    {
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();
        $balance = Balance::whereUserId($user->id)
            ->whereHas('currency', function($query){
                $query->whereCode('idr');
            })
            ->first();

        Sanctum::actingAs($user);
        $response = $this->post(route('withdrawals.create'), [
            'balance_id' => $balance->id,
            'amount' => 200000,
            'bank_code' => 'bni',
            'account_holder_name' => 'Test test',
            'account_number' => '1234567890'
        ]);

        $response->assertStatus(200);
        $withdrawalId = $response->json('data.id');
        $this->assertIsInt($withdrawalId);

        return $withdrawalId;
    }

    /**
     * @depends test_create_withdrawal
     */
    public function test_process_withdrawal(int $withdrawalId)
    {
        $user = User::factory()->create();

        $withdrawalService = app(WithdrawalService::class);

        $withdrawalService->processWithdrawal($user, Withdrawal::find($withdrawalId));

        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawalId,
            'status_id' => Withdrawal::STATUS_PENDING
        ]);

        return $withdrawalId;
    }

    /**
     * @depends test_process_withdrawal
     */
    public function test_withdrawal_xendit_success_webhook(int $withdrawalId)
    {
        $withdrawal = Withdrawal::find($withdrawalId);

        $idrService = app(IdrAdapter::class);
        $webhookData = new DisbursementWebhookData($withdrawalId, DisbursementWebhookData::STATUS_COMPLETED);
        $idrService->processXenditWebhook($webhookData);

        $this->assertDatabaseHas('withdrawals', [
            'id' => $withdrawal->id,
            'status_id' => Withdrawal::STATUS_SUCCESSFUL
        ]);
    }

    public function test_cannot_process_already_processed_withdrawal()
    {
        $this->seed(CurrencySeeder::class);
        $user = User::factory()->create();

        $balance = Balance::whereUserId($user->id)
            ->whereHas('currency', function($query){
                $query->whereCode('idr');
            })
            ->first();

        $withdrawal = Withdrawal::factory()->create(
            [
                'user_id' => $user->id,
                'balance_id' => $balance->id,
                'currency_id' => $balance->currency->id,
                'withdrawal_method' => 'xendit',
                'status_id' => Withdrawal::STATUS_PENDING,
                'amount' => 200000
            ]
        );

        $withdrawalService = app(WithdrawalService::class);

        $this->expectException(WithdrawalCannotBeProcessedException::class);
        $withdrawalService->processWithdrawal($user, $withdrawal);
    }
}
