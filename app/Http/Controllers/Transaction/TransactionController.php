<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Documentation\User\User;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = \Auth::user();
        $transactions = $user->transactions()->with(
            ['fromBalance', 'toBalance', 'fromBalance.currency', 'toBalance.currency']
        )->paginate();

        return $this->response->build(new TransactionCollection($transactions));
    }
}
