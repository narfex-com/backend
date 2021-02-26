<?php

namespace App\Http\Controllers\Rate;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\Rate\RateService;
use Illuminate\Http\Request;

class RateController extends Controller
{
    private RateService $rateService;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;

        parent::__construct();
    }

    public function index()
    {
        $currencies = Currency::available()->select(['code', 'is_fiat'])->get();
        $cryptoCurrencies = $currencies->filter(fn(Currency $currency) => $currency->isCrypto());
        $fiatCurrencies = $currencies->filter(fn(Currency $currency) => $currency->isFiat());

        $cryptoRates = $cryptoCurrencies->map(function (Currency $baseCurrency) use ($fiatCurrencies) {
            return $fiatCurrencies->map(function (Currency $currency) use ($baseCurrency) {
                return [
                    'pair' => "{$baseCurrency->code}-{$currency->code}",
                    'rate' => $this->rateService->getExchangeRate($baseCurrency, $currency)->withFee()->getRate()
                ];
            });
        });

        $fiatRates = $fiatCurrencies->map(function (Currency $baseCurrency) use ($cryptoCurrencies) {
            return $cryptoCurrencies->map(function (Currency $currency) use ($baseCurrency) {
                return [
                    'pair' => "{$baseCurrency->code}-{$currency->code}",
                    'rate' => $this->rateService->getExchangeRate($baseCurrency, $currency)->withFee()->getRate()
                ];
            });
        });

        $rates = $cryptoRates->merge($fiatRates)->flatten(1);

        return $this->response->build($rates->toArray());
    }

    public function get(string $pair)
    {
        $currencies = explode('-', $pair);

        if (!isset($currencies[1])) {
            return $this->response->withErrors([])->withErrorCode('wrong_currencies')->build();
        }

        list ($baseCurrency, $currency) = explode('-', $pair);

        if (!isset($baseCurrency) || !isset($currency)) {
            return $this->response->withErrors([])->withErrorCode('wrong_currencies')->build();
        }

        $baseCurrency = Currency::available()->whereCode($baseCurrency)->first();
        $currency = Currency::available()->whereCode($currency)->first();

        if (!$baseCurrency || !$currency || ($baseCurrency->is_fiat === $currency->is_fiat)) {
            return $this->response->withErrors([])->withErrorCode('wrong_currencies')->build();
        }

        return $this->response->build([
            'rate' => $this->rateService->getExchangeRate($baseCurrency, $currency)->withFee()->getRate()
        ]);
    }
}
