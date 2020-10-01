<?php

namespace Xmen\StarterKit\Models;

use Spatie\Permission\Traits\HasRoles;

trait StarterKit
{
    use HasRoles;

    public function posts()
    {
        return $this->hasMany(\Xmen\StarterKit\Models\Post::class, 'user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(\Xmen\StarterKit\Models\AdminLog::class, 'user_id', 'id');
    }
}
