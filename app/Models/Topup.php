<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Topup
 *
 * @property int $id
 * @property int $user_id
 * @property int $currency_id
 * @property int $balance_id
 * @property int $topup_method_id
 * @property string $amount
 * @property string|null $transaction_id Blockchain transaction id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Topup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Topup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Topup query()
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereTopupMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Balance $balance
 * @property-read \App\Models\Currency $currency
 * @property-read \App\Models\User $user
 * @property string $topup_method
 * @method static \Illuminate\Database\Eloquent\Builder|Topup whereTopupMethod($value)
 */
class Topup extends Model
{
    use HasFactory;

    public const TRANSACTION_TYPE = 'topup';

    public const STATUS_CREATED = 1;
    public const STATUS_DONE = 2;
    public const STATUS_EXPIRED = 3;

    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
