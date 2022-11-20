<?php

namespace Apptive\Core\Brains;

use \Closure;

class Route
{
    public static function when($page, Closure $callback, $before = [])
    {
        if ($_GET[Config::get('app.page_key', 'page')] === $page) {
            if (is_null($before)) {
                $callback();
                Flash::clear();
                exit();
            }

            foreach ($before as $it) {
                if (!is_callable($it)) {
                    throw Ups::invalidBeforeFunction($it);
                }
                call_user_func($it, $page);
            }
            $callback();
            Flash::clear();
            exit();
        }
    }

    public static function url($page, $query = [])
    {
        $query[Config::get('app.page_key', 'page')] = $page;
        return Config::get('app.base_url', 'http://127.0.0.1/') . '?' . http_build_query($query);
    }

    public static function redirect($page, $query = [], $permanent = false)
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: ' . static::url($page, $query));
        exit;
    }
}
