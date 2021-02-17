<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Translation
 *
 * @property int $id
 * @property string $language
 * @property int $type
 * @property string $name
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereValue($value)
 * @mixin \Eloquent
 */
class Translation extends Model
{
    use HasFactory;
}
