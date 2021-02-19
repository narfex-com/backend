<?php


namespace App\Http\Documentation\Currency;


/**
 * @OA\Schema(
 *     title="Currency",
 *     description="Currency model",
 *     @OA\Xml(
 *         name="Currency"
 *     )
 * )
 */
class Currency
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="currency's id",
     *     format="int",
     *     example=1
     * )
     *
     * @var integer
     */
    private int $id;

    /**
     * @OA\Property(
     *     title="code",
     *     description="currency's code",
     *     format="string",
     *     example="btc"
     * )
     *
     * @var string
     */
    private string $code;

    /**
     * @OA\Property(
     *     title="name",
     *     description="currency's name",
     *     format="string",
     *     example="Bitcoin"
     * )
     *
     * @var string
     */
    private string $name;

    /**
     * @OA\Property(
     *     title="is_fiat",
     *     description="is fiat currency (false is crypto)",
     *     format="bool",
     *     example=false
     * )
     *
     * @var bool
     */
    private bool $is_fiat;
}
