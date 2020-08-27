<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MenuItem
 *
 * @property int $id
 * @property string $title
 * @property string $menuable_type
 * @property int $menuable_id
 * @property string|null $kind
 * @property string|null $meta
 * @property int|null $parent
 * @property int $sort
 * @property int $user_id
 * @property int $menu_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereKind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereMenuableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereMenuableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\MenuItem whereUserId($value)
 * @mixin \Eloquent
 */
class MenuItem extends Model {
    protected $guarded = [];

    //
    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function parent() {
        return $this->belongsTo(MenuItem::class, 'parent');
    }

    public function children() {
        return $this->hasMany(MenuItem::class, 'parent');
    }
}
