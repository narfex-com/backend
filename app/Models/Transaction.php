<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $from_currency_id
 * @property int|null $to_currency_id
 * @property int|null $from_balance_id
 * @property int|null $to_balance_id
 * @property string $type_type
 * @property int $type_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFromBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFromCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereToBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereToCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTypeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 * @mixin \Eloquent
 * @property string $typeable_type
 * @property int $typeable_id
 * @property-read Model|\Eloquent $typeable
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTypeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTypeableType($value)
 * @property-read \App\Models\Balance|null $fromBalance
 * @property-read \App\Models\Currency|null $fromCurrency
 * @property-read \App\Models\Balance|null $toBalance
 * @property-read \App\Models\Currency|null $toCurrency
 * @property-read \App\Models\User $user
 */
class Transaction extends Model
{
    use HasFactory;

    public function typeable()
    {
        return $this->morphTo();
    }

    public function fromBalance()
    {
        return $this->belongsTo(Balance::class);
    }

    public function toBalance()
    {
        return $this->belongsTo(Balance::class);
    }

    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function toCurrency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
