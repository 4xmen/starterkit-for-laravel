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
        return 'starterkit';
    }

    static function slug($name, $replace_char = '-') {
        // special chars
        $name = str_replace('&','and',$name);
        $name = str_replace('+','plus',$name);
        $name = str_replace('-','minus',$name);
        $name = str_replace('@','at',$name);
        $name = str_replace('*','star',$name);

        // replace non letter or digits by -
        $name = preg_replace('~[^\pL\d\.]+~u', $replace_char, $name);

        // transliterate
        $name = iconv('utf-8', 'utf-8//TRANSLIT', $name);

        // trim
        $name = trim($name, $replace_char);

        // remove duplicate -
        $name = preg_replace('~-+~', $replace_char, $name);

        // lowercase
        $name = strtolower($name);

        if (empty($name)) {
            return 'N-A';
        }
        return substr($name,0,200);
    }

}
