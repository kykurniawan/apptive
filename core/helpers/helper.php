<?php

use Apptive\Core\Brains\App;
use Apptive\Core\Brains\Config;
use Apptive\Core\Brains\Flash;
use Apptive\Core\Brains\Resource;
use Apptive\Core\Brains\Route;

if (!function_exists('version')) {
    function version()
    {
        return App::VERSION;
    }
}

if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        return Config::get($key, $default);
    }
}

if (!function_exists('flash')) {
    function flash(string $key, $value = null)
    {
        if (is_null($value)) {
            return Flash::get($key);
        }

        Flash::set($key, $value);
    }
}

if (!function_exists('part')) {
    function part($part)
    {
        return Resource::part($part);
    }
}

if (!function_exists('page')) {
    function page()
    {
        return PAGE_FILE;
    }
}

if (!function_exists('url')) {
    function url($page, $query = [])
    {
        return Route::url($page, $query);
    }
}
