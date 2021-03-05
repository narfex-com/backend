<?php


namespace App\Services\Withdrawal\Adapters;


use App\DTOs\Withdrawal\CreateWithdrawalDTO;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\XenditDisbursementDetail;
use App\Services\Withdrawal\Xendit\DisbursementWebhookData;
use Illuminate\Support\Facades\DB;
use Throwable;
use Xendit\Disbursements;

class IdrAdapter implements WithdrawalAdapter
{
    const AVAILABLE_BANK_CODES = ['bni', 'bca', 'bri', 'cimb', 'mandiri', 'permata'];

    /**
     * @param User $admin
     * @param Withdrawal $withdrawal
     * @throws Throwable
     */
    public function withdraw(User $admin, Withdrawal $withdrawal)
    {
        DB::beginTransaction();
        try {
            $withdrawal->admin_id = $admin->id;
            $withdrawal->status_id = Withdrawal::STATUS_PENDING;
            $withdrawal->save();
            $this->sendXenditPayout($withdrawal);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function storeAdditionalDataForWithdrawal(Withdrawal $withdrawal, CreateWithdrawalDTO $dto)
    {
        $request = $dto->getRequest();

        $additionalData = new XenditDisbursementDetail;

        $additionalData->withdrawal()->associate($withdrawal);
        $additionalData->fill($request->only(['bank_code', 'account_holder_name', 'account_number']));

        $additionalData->save();
    }

    public function getAdditionalValidationRules(): array
    {
        $bank_codes = implode(',', self::AVAILABLE_BANK_CODES);

        return [
            'bank_code' => ['required', 'string', "in:$bank_codes"],
            'account_holder_name' => ['required', 'string', 'min:4'],
            'account_number' => ['required', 'string', 'min:6'],
        ];
    }

    private function sendXenditPayout(Withdrawal $withdrawal)
    {
        if (app()->environment('testing')) {
            return;
        }

        $withdrawal->load('xenditDisbursementDetail');

        Disbursements::create([
            'external_id' => $withdrawal->id,
            'amount' => $withdrawal->amount,
            'bank_code' => $withdrawal->xenditDisbursementDetail->bank_code,
            'description' => "Withdrawal #{$withdrawal->id}",
            'account_holder_name' => $withdrawal->xenditDisbursementDetail->account_holder_name,
            'account_number' => $withdrawal->xenditDisbursementDetail->account_number,
        ]);
    }

    public function processXenditWebhook(DisbursementWebhookData $webhookData)
    {
        $withdrawal = $webhookData->getWithdrawal();

        if ($webhookData->isSuccess()) {
            $withdrawal->status_id = Withdrawal::STATUS_SUCCESSFUL;
        } else {
            $withdrawal->status_id = Withdrawal::STATUS_DECLINED;
            $withdrawal->declined_reason = $webhookData->getFailureCode();
            $withdrawal->balance->increaseAmount($withdrawal->amount);
        }

        $withdrawal->save();
    }

    public function getWithdrawalMethod(): string
    {
        return 'xendit';
    }
}
