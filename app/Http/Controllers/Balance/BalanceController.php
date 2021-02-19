<?php

namespace App\Http\Controllers\Balance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Balance\BalanceResource;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * @OA\Get(
     * path="/balances",
     * summary="Get balances",
     * operationId="balancesGet",
     * tags={"balance"},
     * @OA\Response(
     *    response=200,
     *    description="Returns user's balances",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Balance"))
     *    ),
     * ),
     * )
     */
    public function index()
    {
        $balances = \Auth::user()->balances->load('currency');

        return $this->response->build([
            BalanceResource::collection($balances)
        ]);
    }
}
