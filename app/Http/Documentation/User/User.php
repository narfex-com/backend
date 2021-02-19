<?php


namespace App\Http\Documentation\User;

use App\Http\Documentation\Balance\Balance;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User
{
    /**
     * @OA\Property(property="id", type="integer", readOnly="true", example="1")
     *
     * @var int
     */
    private int $id;

    /**
     * @OA\Property(property="first_name", type="string", maxLength=32, example="John"),
     *
     * @var string
     */
    private string $first_name;

    /**
     * @OA\Property(property="last_name", type="string", maxLength=32, example="Doe"),
     *
     * @var string
     */
    private string $last_name;

    /**
     * @OA\Property(property="nickname", type="string", maxLength=32, example="johndoe23"),
     *
     * @var string
     */
    private string $nickname;

    /**
     * @OA\Property(property="email", type="string", format="email", example="email@mail.com"),
     *
     * @var string
     */
    private string $email;

    /**
     * @OA\Property(
     *     property="balances",
     *     title="Balances",
     *     type="array",
     *     description="User's balances",
     *     @OA\Items(ref="#/components/schemas/Balance")
     * )
     *
     * @var Balance[]
     */
    private array $balances;
}
