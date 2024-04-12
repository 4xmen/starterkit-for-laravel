<?php

namespace Xmen\StarterKit;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Xmen\StarterKit\StarterKit
 */
class StarterKitFacade extends Facade
{
    public static $scripts=[];
    public static $styles=[];

    protected static function getFacadeAccessor()
    {
        return 'starterkit';
    }

    public static function slug($name, $replace_char = '-')
    {
        // special chars
        $name = str_replace(['&', '+' , '@', '*'], ['and', 'plus', 'at', 'star'], $name);

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

        return substr($name, 0, 200);
    }

    /**
     * Get all of the additional scripts that should be registered.
     *
     * @return array
     */
    public static function allScripts()
    {
        return static::$scripts;
    }

    /**
     * Get all of the additional stylesheets that should be registered.
     *
     * @return array
     */
    public static function allStyles()
    {
        return static::$styles;
    }

    /**
     * Register the given script file with Starter-Kit.
     *
     * @param  string  $name
     * @param  string  $path
     * @return static
     */
    public static function script($name, $path)
    {
        static::$scripts[$name] = $path;

        return new static;
    }

    /**
     * Register the given CSS file with Starter-Kit.
     *
     * @param  string  $name
     * @param  string  $path
     * @return static
     */
    public static function style($name, $path)
    {
        static::$styles[$name] = $path;

        return new static;
    }}
