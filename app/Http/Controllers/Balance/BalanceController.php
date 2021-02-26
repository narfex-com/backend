<?php

namespace App\Http\Controllers\Balance;

use App\Exceptions\Balance\CurrencyNotImplementedException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Balance\BalanceResource;
use App\Models\Currency;
use App\Services\Balance\BalanceService;
use Illuminate\Http\JsonResponse;

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
    public function index(): JsonResponse
    {
        $balances = \Auth::user()->balances->load('currency');

        return $this->response->build([
            BalanceResource::collection($balances)
        ]);
    }

    /**
     * @OA\Post(
     * path="/balances/{currency}",
     * summary="Create a balance",
     * operationId="balanceCreate",
     * tags={"balance"},
     * @OA\Parameter(
     *     in="path",
     *     name="currency",
     *     description="Currency's id",
     *     required=true
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Returns the created balance",
     *     @OA\JsonContent(
     *        @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Balance"))
     *     ),
     * ),
     * @OA\Response(
     *     response=400,
     *     description="The currency is not implemented yet",
     *     @OA\JsonContent(
     *        @OA\Property(property="errors", type="object",
     *          @OA\Property(property="message", type="string", example="The currency is not implemented yet", description="Translated error to display"),
     *     ),
     *     ),
     * ),
     * )
     * @param Currency $currency
     * @param BalanceService $balanceService
     * @return JsonResponse
     */
    public function create(Currency $currency, BalanceService $balanceService): JsonResponse
    {
        try {
            $balance = $balanceService->create(\Auth::user(), $currency);
        } catch (CurrencyNotImplementedException $e) {
            return $this->response->withErrors([
                'message' => 'The currency is not available yet'
            ])->build();
        }

        return $this->response->build(new BalanceResource($balance));
    }
}
