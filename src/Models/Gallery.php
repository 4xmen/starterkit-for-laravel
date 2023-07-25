<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Gallery
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property int $status
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Gallery whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Xmen\StarterKit\Models\Image[] $images
 * @property-read int|null $images_count
 */
class Gallery extends Model implements HasMedia
{
    use  InteractsWithMedia;


    public function images()
    {
        return $this->hasMany(Image::class, 'gallery_id', 'id')->orderBy('sort')->orderByDesc('id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('gallery-image')->optimize();

        $t = explode('x',config('starter-kit.gallery_thumb'));

        if (config('starter-kit.gallery_thumb') == null || config('starter-kit.gallery_thumb') == ''){
            $t[0] = 500 ;
            $t[1] = 500 ;
        }


        $this->addMediaConversion('gthumb')->width($t[0])
            ->height($t[1])
            ->crop(Manipulations::CROP_CENTER, $t[0], $t[1])->optimize();
//                    ->watermark(public_path('images/logo.png'))->watermarkOpacity(50);
//                    ->withResponsiveImages();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function imgurl()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()->first()->getUrl('gthumb');
        } else {
            return "no image";
        }
    }

    //
}
