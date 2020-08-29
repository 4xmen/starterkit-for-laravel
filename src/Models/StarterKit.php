<?php

namespace Xmen\StarterKit\Models;

trait StarterKit
{
    public function news(){
        return $this->hasMany(\Xmen\StarterKit\Models\News::class,'user_id','id');
    }

    public function logs(){
        return $this->hasMany(\Xmen\StarterKit\Models\AdminLog::class,'user_id','id');
    }
}