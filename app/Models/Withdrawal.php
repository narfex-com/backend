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
 */
class Withdrawal extends Model
{
    use HasFactory;

    public const TRANSACTION_TYPE = 'withdrawal';
}
