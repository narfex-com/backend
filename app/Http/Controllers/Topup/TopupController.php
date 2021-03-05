<?php

namespace App\Http\Controllers\Topup;

use App\Exceptions\Topup\TopupCurrencyNotFoundException;
use App\Exceptions\Topup\TopupException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Topup\CreateTopupRequest;
use App\Models\Balance;
use App\Models\Currency;
use App\Services\Topup\TopupService;

class TopupController extends Controller
{
    private TopupService $topupService;

    public function __construct(TopupService $topupService)
    {
        $this->topupService = $topupService;

        parent::__construct();
    }

    public function create(CreateTopupRequest $request)
    {
        $user = \Auth::user();

        $currency = Currency::available()->whereId($request->get('currency_id'))->first();

        if (!$currency) {
            return $this->response->withErrorCode('currency_not_supported')->build();
        }

        $balance = Balance::whereUserId($user->id)->whereCurrencyId($currency->id)->first();

        if (!$balance) {
            return $this->response->withErrorCode('balance_not_found')->build();
        }

        try {
            $topup = $this->topupService->create($balance, $request->get('amount'));
        } catch (TopupCurrencyNotFoundException $e) {
            return $this->response->withErrorCode('currency_not_supported')->build();
        } catch (TopupException $e) {
            return $this->response->withErrorCode('topup_not_available')->build();
        }

        return $this->response->build([
            'redirect_url' => $topup->getRedirectUrl()
        ]);
    }
}
