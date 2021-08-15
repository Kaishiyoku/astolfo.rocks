<?php

namespace App\Models;

use App\Casts\Hex;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * App\Models\Image
 *
 * @property int $external_id
 * @property string $url
 * @property string $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $views
 * @property string|null $source
 * @property string $mimetype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereMimetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereViews($value)
 * @mixin \Eloquent
 * @property mixed|null $image_identifier
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageIdentifier($value)
 * @property mixed|null $identifier
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereIdentifier($value)
 * @property mixed|null $identifier_image
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereIdentifierImage($value)
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
        'external_id', 'url', 'rating', 'views', 'source',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'identifier', 'identifier_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->orderBy('name', 'asc');
    }

    public function getFilePath()
    {
        $fileExtension = File::extension($this->url);
        $fileName = "{$this->external_id}.{$fileExtension}";

        return "astolfo/{$fileName}";
    }
}
