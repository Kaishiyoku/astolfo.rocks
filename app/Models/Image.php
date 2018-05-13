<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Image
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $external_id
 * @property string $url
 * @property string $rating
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUrl($value)
 */
class Image extends Model
{
    public $primaryKey = 'external_id';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'external_id', 'url', 'rating',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
}
