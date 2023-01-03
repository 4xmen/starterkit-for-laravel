<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;
use Xmen\StarterKit\Helpers\TDate;

/**
 * App\AdminLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string $logable_type
 * @property int $logable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereLogableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereLogableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereUserId($value)
 * @mixin \Eloquent
 * @property string $loggable_type
 * @property int $loggable_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereLoggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\AdminLog whereLoggableType($value)
 * @property-read \Xmen\StarterKit\Models\User $user
 */
class AdminLog extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(App\Models\User::class, 'user_id', 'id');
    }

    public function persianDate()
    {
        $dt = TDate::GetInstance();

        return $dt->PDate("Y/m/d H:i:s", $this->created_at->timestamp);
    }
}
