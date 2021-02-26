<?php

namespace App\Http\Controllers\Exchange;

use App\Exceptions\Exchange\AccessViolationException;
use App\Exceptions\Exchange\InsufficientFundsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exchange\CreateExchangeRequest;
use App\Models\Balance;
use App\Services\Exchange\ExchangeService;

class ExchangeController extends Controller
{
    private ExchangeService $exchangeService;

    public function __construct(ExchangeService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
        parent::__construct();
    }

    public function exchange(CreateExchangeRequest $request)
    {
        $user = \Auth::user();

        $fromBalance = Balance::whereUserId($user->id)
            ->whereId($request->get('from_balance_id'))->firstOrFail();

        $toBalance = Balance::whereUserId($user->id)
            ->whereId($request->get('to_balance_id'))->firstOrFail();

        $fromAmount = $request->get('from_amount');
        $toAmount = $request->get('to_amount');
        $isAssetAmount = $request->get('is_from_amount');

        try {
            $exchange = $this->exchangeService->exchange($user, $fromBalance, $toBalance, $fromAmount, $toAmount, $isAssetAmount);

            return $this->response->build([
                $exchange
            ]);
        } catch (AccessViolationException $e) {
            return $this->response->withErrors([
                'message' => 'Wrong balance id'
            ])->build();
        } catch (InsufficientFundsException $e) {
            return $this->response->withErrors([
                'message' => 'Insufficient funds'
            ])->build();
        }
    }
}
