<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Balance\BalanceResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 * @OA\Schema(
 * schema="User",
 * @OA\Xml(name="User"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="email", type="string", format="email", example="email@mail.com"),
 * @OA\Property(property="nickname", type="string", example="nickname"),
 * @OA\Property(property="first_name", type="string", maxLength=32, example="John"),
 * @OA\Property(property="last_name", type="string", maxLength=32, example="Doe"),
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $this */

        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'nickname' => $this->nickname,
            'balances' => BalanceResource::collection($this->balances)
        ];
    }
}
