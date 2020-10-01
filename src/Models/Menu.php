<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Menu
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu whereUserId($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Menu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\Menu whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Menu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Xmen\StarterKit\Models\Menu withoutTrashed()
 */
class Menu extends Model
{
    //
    use  SoftDeletes;

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id');
    }
}
