<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Exchange
 *
 * @property int $id
 * @property int $user_id
 * @property int $from_balance_id
 * @property int $to_balance_id
 * @property int $from_currency_id
 * @property int $to_currency_id
 * @property string $rate
 * @property string $from_amount
 * @property string $to_amount
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereFromAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereFromBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereFromCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereToAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereToBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereToCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exchange whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Balance $fromBalance
 * @property-read \App\Models\Currency $fromCurrency
 * @property-read \App\Models\Balance $toBalance
 * @property-read \App\Models\Currency $toCurrency
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Transaction|null $transaction
 */
class Exchange extends Model
{
    use HasFactory;

    const EXCHANGE_STATUS_CREATED = 1;
    const EXCHANGE_STATUS_SUCCESSFUL = 2;
    const EXCHANGE_STATUS_DECLINED = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'typeable');
    }
}
