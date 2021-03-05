<?php

namespace App\Http\Controllers\Withdrawal;

use App\Exceptions\Withdrawal\CurrencyNotSupportedException;
use App\Exceptions\Withdrawal\InsufficientFundsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Withdrawal\CreateWithdrawalRequest;
use App\Http\Resources\Withdrawal\WithdrawalResource;
use App\Services\Withdrawal\WithdrawalService;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    private WithdrawalService $withdrawalService;

    public function __construct(WithdrawalService $withdrawalService)
    {
        $this->withdrawalService = $withdrawalService;
        parent::__construct();
    }

    public function withdraw(CreateWithdrawalRequest $request)
    {
        try {
            $withdrawal = $this->withdrawalService->createWithdrawal($request->getDto());
        } catch (InsufficientFundsException $e) {
            return $this->response->withErrorCode('insufficient_funds')->build();
        } catch (CurrencyNotSupportedException $e) {
            return $this->response->withErrorCode('currency_not_supported')->build();
        }

        return $this->response->build(new WithdrawalResource($withdrawal));
    }
}
