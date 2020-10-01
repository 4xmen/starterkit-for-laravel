<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Adv
 *
 * @property int $id
 * @property string $title
 * @property string $expire
 * @property string $image
 * @property int $max_click
 * @property int $click
 * @property int $active
 * @property string $link
 * @property int $user_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereClick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereMaxClick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Adv whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Adv onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Adv withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Adv withoutTrashed()
 */
class Adv extends Model
{
    //
    use SoftDeletes;

    public function imgUrl()
    {
        if ($this->image == null) {
            return null;
        }

        return \Storage::url('advs/' . $this->image);
    }
}
