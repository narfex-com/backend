<?php


namespace App\Http\Documentation\Balance;


use App\Models\Currency;

/**
 * @OA\Schema(
 *     title="Balance",
 *     description="Balance model",
 *     @OA\Xml(
 *         name="Balance"
 *     )
 * )
 */
class Balance
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="id",
     *     format="int",
     *     example=1
     * )
     *
     * @var integer
     */
    private int $id;

    /**
     * @OA\Property(
     *     title="currency",
     *     format="object",
     *     ref="#/components/schemas/Currency",
     *     description="balance's currency"
     * )
     *
     * @var Currency
     */
    private $currency;

    /**
     * @OA\Property(
     *     title="amount",
     *     description="balance's amount",
     *     format="float",
     *     example=0.0023
     * )
     *
     * @var float
     */
    private float $amount;

    /**
     * @OA\Property(
     *     title="address",
     *     description="balance's address in blockchain",
     *     format="string",
     *     example="0x1ka36qerzv8nz72dfg34ak462"
     * )
     *
     * @var string|null
     */
    private ?string $address;
}
