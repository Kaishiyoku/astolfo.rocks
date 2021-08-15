<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PossibleDuplicate
 *
 * @property int $id
 * @property int $image_external_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate query()
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereImageExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $image_external_id_left
 * @property int $image_external_id_right
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereImageExternalIdLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereImageExternalIdRight($value)
 */
class PossibleDuplicate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_external_id_left', 'image_external_id_right',
    ];
}
