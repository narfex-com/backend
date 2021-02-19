<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WithdrawalMethod
 *
 * @property int $id
 * @property int $currency_id
 * @property string $name
 * @property float $fee
 * @property string $limit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalMethod whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WithdrawalMethod extends Model
{
    use HasFactory;
}
