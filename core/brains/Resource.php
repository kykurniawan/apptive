<?php

namespace Apptive\Core\Brains;

use \Error;

class Resource
{
    public static function page($page)
    {
        if (!file_exists(APP_PATH . '/resources/pages/' . $page . '.php')) {
            throw new Error('Page file not found');
        }

        return APP_PATH . '/resources/pages/' . $page . '.php';
    }

    public static function layout($layout)
    {
        if (!file_exists(APP_PATH . '/resources/layouts/' . $layout . '.php')) {
            throw new Error('Layout page file not found');
        }

        return APP_PATH . '/resources/layouts/' . $layout . '.php';
    }

    public static function part($part)
    {
        if (!file_exists(APP_PATH . '/resources/parts/' . $part . '.php')) {
            throw new Error('View part not found');
        }

        return APP_PATH . '/resources/parts/' . $part . '.php';
    }

    public static function error($error)
    {
        if (!file_exists(APP_PATH . '/resources/errors/' . $error . '.php')) {
            throw new Error('Error file not found');
        }

        return APP_PATH . '/resources/errors/' . $error . '.php';
    }
}
