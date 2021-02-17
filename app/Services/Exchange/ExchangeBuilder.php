<?php


namespace App\Services\Exchange;


use App\Models\Balance;
use App\Models\User;

class ExchangeBuilder
{
    private User $user;
    private Balance $fromBalance;
    private Balance $toBalance;
    private float $amount;
    private bool $isFromBalance;


}
