<?php


namespace App\Services\Balance\CurrencyServices;


use App\Models\Balance;
use App\Models\Currency;
use App\Models\User;

interface CurrencyService
{
    public function __construct(Currency $currency);

    public function create(User $user): Balance;
}
