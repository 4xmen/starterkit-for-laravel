<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * App\Poll
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int $user_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Xmen\StarterKit\Models\Opinion[] $opinions
 * @property-read int|null $opinions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Poll whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Poll onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Poll withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Poll withoutTrashed()
 */
class Poll extends Model
{
    use  SoftDeletes, HasTranslations;

    //
    protected $guarded = [];

    public function opinions()
    {
        return $this->hasMany(Opinion::class, 'poll_id', 'id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
