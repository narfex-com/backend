<?php

namespace App\Http\Controllers;

use App\Http\Responses\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="narfex API",
 *    version="1.0.0",
 * )
 */
class Controller extends BaseController
{
    protected JsonResponse $response;

    public function __construct(JsonResponse $jsonResponse)
    {
        $this->response = $jsonResponse;
    }

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
