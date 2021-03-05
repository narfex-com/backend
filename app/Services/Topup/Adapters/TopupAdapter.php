<?php


namespace App\Services\Topup\Adapters;


use App\Models\Balance;
use App\Services\Topup\Topup;

interface TopupAdapter
{
    public function create(Balance $balance, float $amount): Topup;
}
