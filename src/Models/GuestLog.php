<?php

namespace Xmen\StarterKit\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GuestLog
 *
 * @property int $id
 * @property string $ip
 * @property string $action
 * @property string $logable_type
 * @property int $logable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereLogableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereLogableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $loggable_type
 * @property int $loggable_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereLoggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Xmen\StarterKit\Models\GuestLog whereLoggableType($value)
 */
class GuestLog extends Model
{
    //
    protected $guarded = [];
}
