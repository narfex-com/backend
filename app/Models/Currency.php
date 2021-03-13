<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $is_fiat
 * @property int $is_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereIsEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereIsFiat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static Builder|Currency available()
 */
class Currency extends Model
{
    use HasFactory;

    public function scopeAvailable(Builder $query)
    {
        $query->where('is_enabled', true);
    }

    public function isFiat(): bool
    {
        return $this->is_fiat;
    }

    public function isCrypto(): bool
    {
        return !$this->is_fiat;
    }

    public function hasSameType(Currency $currency): bool
    {
        return $this->is_fiat === $currency->is_fiat;
    }
}
