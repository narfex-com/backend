<?php


namespace App\Services\Withdrawal\Adapters;


use App\DTOs\Withdrawal\CreateWithdrawalDTO;
use App\Models\User;
use App\Models\Withdrawal;

interface WithdrawalAdapter
{
    public function withdraw(User $user, Withdrawal $withdrawal);

    public function storeAdditionalDataForWithdrawal(Withdrawal $withdrawal, CreateWithdrawalDTO $dto);

    public function getAdditionalValidationRules(): array;

    public function getWithdrawalMethod(): string;
}
