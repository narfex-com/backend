<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     * path="/profile",
     * summary="Get profile",
     * operationId="profileGet",
     * tags={"profile"},
     * @OA\Response(
     *    response=200,
     *    description="Profile",
     *    @OA\JsonContent(
     *       @OA\Property(property="user", type="object", ref="#/components/schemas/User")
     *    )
     * ),
     * )
     */
    public function index()
    {
        return $this->response->build(
            [
                'user' => new UserResource(\Auth::user()),
            ]
        );
    }
}
