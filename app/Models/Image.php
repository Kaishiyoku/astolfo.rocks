<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ImageManager;
use Intervention\Image\Exception\NotReadableException;
use Storage;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property mixed|null $identifier_image
 * @property string|null $identifier
 * @property string $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $views
 * @property string|null $source
 * @property string $file_extension
 * @property string|null $mimetype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereFileExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereIdentifierImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereMimetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereViews($value)
 * @mixin \Eloquent
 * @property int $file_size
 * @property int $width
 * @property int $height
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereWidth($value)
 */
class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating',
        'views',
        'source',
        'file_extension',
        'mimetype',
        'file_size',
        'width',
        'height',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'identifier',
        'identifier_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 24;

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->orderBy('name');
    }

    public function getFileName(): string
    {
        return "{$this->id}.{$this->file_extension}";
    }

    public function getFilePath(): string
    {
        return Storage::disk('astolfo')->url($this->getFileName());
    }

    public function getImageFromStorage(): ?\Intervention\Image\Image
    {
        if (!$this->mimetype) {
            return null;
        }

        try {
            return ImageManager::make(Storage::disk('astolfo')->path($this->getFileName()));
        } catch (NotReadableException $e) {
            return null;
        }
    }

    public function getImageDataFromStorage(): ?string
    {
        return optional($this->getImageFromStorage(), function ($data) {
            return $data->psrResponse()->getBody()->getContents();
        });
    }

    public function getMimetypeFromStorage(): ?string
    {
        if (Storage::disk('astolfo')->exists($this->getFileName())) {
            return Storage::disk('astolfo')->mimeType($this->getFileName());
        }

        return null;
    }
}
