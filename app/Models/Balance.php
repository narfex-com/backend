<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Balance
 *
 * @property int $id
 * @property int $user_id
 * @property int $currency_id
 * @property string $address
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Balance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Balance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Balance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Balance whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Currency $currency
 */
class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency_id'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function checkFunds(float $amount): bool
    {
        $balance = \DB::table('balances')->select(['id', 'amount'])->where('id', $this->id)->first();
        return $balance->amount > $amount;
    }

    public function reduceAmount(float $amount)
    {
        \DB::table('balances')->where('id', $this->id)->decrement('amount', $amount);
    }

    public function increaseAmount(float $amount)
    {
        \DB::table('balances')->where('id', $this->id)->increment('amount', $amount);
    }
}
