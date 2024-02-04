<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * App\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $sort
 * @property int|null|\Xmen\StarterKit\Models\Category $parent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Category withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Xmen\StarterKit\Models\Post[] $news
 * @property-read int|null $news_count
 */
class Category extends Model
{
    use SoftDeletes,HasTranslations;

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    //
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
