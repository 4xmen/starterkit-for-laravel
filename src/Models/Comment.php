<?php

namespace Xmen\StarterKit\Models;

use App\Helpers\TDate;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property int $id
 * @property string $body
 * @property string $name
 * @property string $email
 * @property int $status
 * @property int|null $sub_comment_id
 * @property string $commentable_type
 * @property int $commentable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ip
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereSubCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Xmen\StarterKit\Models\Comment[] $approved_children
 * @property-read int|null $approved_children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Xmen\StarterKit\Models\Comment[] $children
 * @property-read int|null $children_count
 */
class Comment extends Model
{
    protected $guarded = [];
    //
    public function commentable()
    {
        return $this->morphTo();
    }

    public function children(){
        return $this->hasMany(Comment::class,'sub_comment_id');
    }

    public function approved_children(){
        return $this->hasMany(Comment::class,'sub_comment_id')->where('status',1);
    }


    public function persianDate(){
        $dt = TDate::GetInstance();
        return $dt->RDate($this->created_at->timestamp);
    }
}
