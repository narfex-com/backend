<?php


namespace App\Services\Withdrawal;


use App\DTOs\Withdrawal\CreateWithdrawalDTO;
use App\Exceptions\Withdrawal\CurrencyNotSupportedException;
use App\Exceptions\Withdrawal\InsufficientFundsException;
use App\Exceptions\Withdrawal\WithdrawalCannotBeProcessedException;
use App\Models\Balance;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalService
{
    private WithdrawalProcessManager $withdrawalProcessManager;

    public function __construct(WithdrawalProcessManager $withdrawalProcessManager)
    {
        $this->withdrawalProcessManager = $withdrawalProcessManager;
    }

    /**
     * @param CreateWithdrawalDTO $dto
     * @return Withdrawal
     * @throws InsufficientFundsException|CurrencyNotSupportedException
     */
    public function createWithdrawal(CreateWithdrawalDTO $dto): Withdrawal
    {
        $processManager = $this->withdrawalProcessManager->make($dto->getBalance()->currency);
        if (!$dto->getBalance()->checkFunds($dto->getAmount())) {
            throw new InsufficientFundsException();
        }

        $withdrawal = new Withdrawal();
        $withdrawal->amount = $dto->getAmount();
        $withdrawal->balance_id = $dto->getBalance()->id;
        $withdrawal->withdrawal_method = $processManager->getWithdrawalMethod();
        $withdrawal->user_id = $dto->getBalance()->user_id;
        $withdrawal->currency_id = $dto->getBalance()->currency_id;
        $withdrawal->status_id = Withdrawal::STATUS_CREATED;
        $withdrawal->save();

        $processManager->storeAdditionalDataForWithdrawal($withdrawal, $dto);
        return $withdrawal;
    }

    /**
     * @param User $admin
     * @param Withdrawal $withdrawal
     * @throws WithdrawalCannotBeProcessedException
     * @throws CurrencyNotSupportedException
     */
    public function processWithdrawal(User $admin, Withdrawal $withdrawal)
    {
        if (!$withdrawal->isAbleToProcess()) {
            throw new WithdrawalCannotBeProcessedException();
        }

        $this->withdrawalProcessManager->make($withdrawal->currency)->withdraw($admin, $withdrawal);
    }
}
