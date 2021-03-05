<?php


namespace App\DTOs\Withdrawal;


use App\Models\Balance;
use Illuminate\Http\Request;

class CreateWithdrawalDTO
{
    private Balance $balance;

    private float $amount;

    private Request $request;

    /**
     * CreateWithdrawalDTO constructor.
     * @param Balance $balance
     * @param float $amount
     * @param Request $request
     */
    public function __construct(Balance $balance, float $amount, Request $request)
    {
        $this->balance = $balance;
        $this->amount = $amount;
        $this->request = $request;
    }

    /**
     * @return Balance
     */
    public function getBalance(): Balance
    {
        return $this->balance;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
