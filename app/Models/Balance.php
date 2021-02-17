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

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
