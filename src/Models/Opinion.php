<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Opinion
 *
 * @property int $id
 * @property int $poll_id
 * @property string $title
 * @property int $vote
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Xmen\StarterKit\Models\Poll $poll
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion wherePollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Opinion whereVote($value)
 * @mixin \Eloquent
 */
class Opinion extends Model
{
    protected $guarded = [];

    //
    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id', 'id');
    }
}
