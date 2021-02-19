<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WithdrawalRequest
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WithdrawalRequest extends Model
{
    use HasFactory;
}
