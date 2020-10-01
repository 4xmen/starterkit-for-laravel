<?php

namespace Xmen\StarterKit\Models;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Clip
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $body
 * @property string $file
 * @property int $user_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array $tag_names
 * @property-read \Illuminate\Database\Eloquent\Collection|\Tagged[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\Conner\Tagging\Model\Tagged[] $tagged
 * @property-read int|null $tagged_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip newQuery()
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Clip onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip withAllTags($tagNames)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip withAnyTag($tagNames)
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Clip withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip withoutTags($tagNames)
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Clip withoutTrashed()
 * @mixin \Eloquent
 * @property string $cover
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Clip whereCover($value)
 */
class Clip extends Model
{
    //
    use  SoftDeletes, Taggable;


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function coverUrl()
    {
        if ($this->cover == null) {
            return null;
        }

        return \Storage::url('clips/' . $this->cover);
    }

    public function fileUrl()
    {
        if ($this->file == null) {
            return null;
        }

        return \Storage::url('clips/' . $this->file);
    }
}
