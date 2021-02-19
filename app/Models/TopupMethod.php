<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TopupMethod
 *
 * @property int $id
 * @property int $user_id
 * @property int $currency_id
 * @property int $balance_id
 * @property int $withdrawal_method_id
 * @property string $amount
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereBalanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TopupMethod whereWithdrawalMethodId($value)
 * @mixin \Eloquent
 */
class TopupMethod extends Model
{
    use HasFactory;
}
