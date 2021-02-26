<?php

namespace App\Http\Controllers\Currency;

use App\Http\Controllers\Controller;
use App\Http\Resources\Currency\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * @OA\Get(
     * path="/currencies",
     * summary="Get currencies",
     * operationId="currenciesGet",
     * tags={"currency"},
     * @OA\Response(
     *    response=200,
     *    description="Returns available currencies",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Currency"))
     *    ),
     * ),
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response->build(CurrencyResource::collection(Currency::all()));
    }
}
