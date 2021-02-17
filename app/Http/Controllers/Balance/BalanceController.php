<?php

namespace App\Http\Controllers\Balance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Balance\BalanceResource;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function index()
    {
        $balances = \Auth::user()->balances->load('currency');

        return $this->response->build([
            BalanceResource::collection($balances)
        ]);
    }
}
