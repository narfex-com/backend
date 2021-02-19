<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     * path="/auth/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successfull login",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object",
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *              @OA\Property(property="access_token", type="string", example="1|f9511jkjasdghylnb347ko"),
     *          )
     *       )
     *    )
     *    ),
     * ),
     *
     * @OA\Response(
     *    response=401,
     *    description="Wrong credentials",
     * ),
     * )
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        /** @var User $user */
        $user = User::whereEmail($email)->first();

        if (!Hash::check($password, $user->password)) {
            return $this->response->withErrors([
                'message' => 'Wrong credentials'
            ], 401)->build();
        }

        return $this->response->build(
            [
                'user' => new UserResource($user),
                'access_token' => $user->createToken('web')->plainTextToken
            ]
        );
    }
}
