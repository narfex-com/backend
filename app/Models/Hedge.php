<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hedge
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Hedge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hedge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hedge query()
 * @method static \Illuminate\Database\Eloquent\Builder|Hedge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hedge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hedge whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Hedge extends Model
{
    use HasFactory;
}
