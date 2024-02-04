<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Image
 *
 * @property int $id
 * @property int $gallery_id
 * @property int $user_id
 * @property string $string
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image whereGalleryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image whereString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $title
 * @property-read \Xmen\StarterKit\Models\Gallery $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Image whereTitle($value)
 */
class Image extends Model implements HasMedia
{
    use  InteractsWithMedia, HasTranslations;


    public $translatable = ['title'];

    protected $guarded = [];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {

        $t = explode('x', config('starter-kit.post_thumb'));
        if (config('starter-kit.gallery_thumb') == null || config('starter-kit.gallery_thumb') == '') {
            $t[0] = 500;
            $t[1] = 500;
        }

        $this->addMediaConversion('image-image')->optimize();

        $this->addMediaConversion('gthumb')->width($t[0])
            ->height($t[1])
            ->crop(Manipulations::CROP_CENTER, $t[0], $t[1])->optimize();
//                    ->watermark(public_path('images/logo.png'))->watermarkOpacity(50);
//                    ->withResponsiveImages();
    }

    public function imgurl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('ithumb');
        } else {
            return "no image";
        }
    }
    //
}
