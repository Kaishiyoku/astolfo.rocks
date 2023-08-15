<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PossibleDuplicate
 *
 * @property int $id
 * @property int $image_id_left
 * @property int $image_id_right
 * @property int $is_false_positive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Image $imageLeft
 * @property-read \App\Models\Image $imageRight
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate query()
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereImageIdLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereImageIdRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereIsFalsePositive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PossibleDuplicate whereUpdatedAt($value)
 * @mixin \Eloquent
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
        'image_id_left',
        'image_id_right',
        'is_false_positive',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    public function imageLeft()
    {
        return $this->belongsTo(Image::class, 'image_id_left');
    }

    public function imageRight()
    {
        return $this->belongsTo(Image::class, 'image_id_right');
    }
}
