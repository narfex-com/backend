<?php


namespace App\Services\Withdrawal\Adapters;


use App\DTOs\Withdrawal\CreateWithdrawalDTO;
use App\Models\User;
use App\Models\Withdrawal;

class BtcAdapter implements WithdrawalAdapter
{
    public function withdraw(User $admin, Withdrawal $withdrawal)
    {
        // TODO: Implement withdraw() method.
    }

    public function storeAdditionalDataForWithdrawal(Withdrawal $withdrawal, CreateWithdrawalDTO $dto)
    {
        // TODO: Implement storeAdditionalDataForWithdrawal() method.
    }

    public function getAdditionalValidationRules(): array
    {
        // TODO: Implement getAdditionalValidationRules() method.
    }

    public function getWithdrawalMethod(): string
    {
        return 'blockchain.com';
    }
}
