<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Withdrawal
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $admin_id
 * @property int $currency_id
 * @property int $balance_id
 * @property int $withdrawal_method_id
 * @property string $amount
 * @property int $status_id
 * @property string|null $transaction_id Blockchain transaction id
 * @property string|null $declined_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereDeclinedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereWithdrawalMethodId($value)
 * @mixin \Eloquent
 * @property string $withdrawal_method
 * @property-read \App\Models\Balance $balance
 * @property-read \App\Models\Currency $currency
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \App\Models\User $user
 * @property-read \App\Models\XenditDisbursementDetail|null $xenditDisbursementDetail
 * @method static \Illuminate\Database\Eloquent\Builder|Withdrawal whereWithdrawalMethod($value)
 */
class Withdrawal extends Model
{
    use HasFactory;

    public const TRANSACTION_TYPE = 'withdrawal';

    const STATUS_CREATED = 1;
    const STATUS_PENDING = 2;
    const STATUS_SUCCESSFUL = 3;
    const STATUS_DECLINED = 4;

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'typeable');
    }

    public function xenditDisbursementDetail()
    {
        return $this->hasOne(XenditDisbursementDetail::class);
    }

    public function isAbleToProcess(): bool
    {
        return $this->status_id === self::STATUS_CREATED;
    }
}
