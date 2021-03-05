<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\XenditDisbursementDetail
 *
 * @property int $id
 * @property int $withdrawal_id
 * @property string $bank_code
 * @property string $account_holder_name
 * @property string $account_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Withdrawal $withdrawal
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail whereAccountHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail whereBankCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|XenditDisbursementDetail whereWithdrawalId($value)
 * @mixin \Eloquent
 */
class XenditDisbursementDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_code',
        'account_holder_name',
        'account_number',
        'withdrawal_id'
    ];

    public function withdrawal()
    {
        return $this->belongsTo(Withdrawal::class);
    }
}
