<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     * path="/auth/register",
     * summary="Sign up",
     * description="Register new user",
     * operationId="authRegister",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="first_name", type="string", format="email", example="John"),
     *       @OA\Property(property="last_name", type="string", format="email", example="Smith"),
     *       @OA\Property(property="nickname", type="string", format="email", example="nickname"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Successfull register",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object",
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *              @OA\Property(property="access_token", type="string", example="1|f9511jkjasdghylnb347ko"),
     *       )
     *       )
     *    )
     *    ),
     * ),
     * @OA\Response(
     *    response=400,
     *    description="User with nickname or email already exists",
     * ),
     * @OA\Response(
     *    response=419,
     *    description="Some of request's data is wrong",
     * ),
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $userExists = User::whereEmail($request->get('email'))
            ->orWhere('nickname', $request->get('nickname'))
            ->first();

        \Log::info('User exists before', [$userExists]);
        if ($userExists) {
            \Log::info('User exists after', [$userExists]);

            return $this->response->withErrors([
                'message' => 'Email or nickname already exists'
            ])->build();
        }

        $user = new User();
        $user->email = $request->get('email');
        $user->nickname = $request->get('nickname');
        $user->password = bcrypt($request->get('password'));
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->save();


        return $this->response->build(
            [
                'user' => new UserResource($user),
                'access_token' => $user->createToken('web')->plainTextToken
            ]
        );
    }
}
