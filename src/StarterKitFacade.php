<?php

namespace Xmen\StarterKit;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xmen\StarterKit\StarterKit
 */
class StarterKitFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'starter-kit';
    }
}
