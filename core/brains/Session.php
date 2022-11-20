<?php

namespace Apptive\Core\Brains;

class Session
{
    public static function set(string $key, $value = null)
    {
        $_SESSION[Config::get('session.key', '__')][$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        if (isset($_SESSION[Config::get('session.key', '__')][$key])) {
            return $_SESSION[Config::get('session.key', '__')][$key];
        }
        return $default;
    }

    public static function delete(string $key)
    {
        if (isset($_SESSION[Config::get('session.key', '__')][$key])) {
            unset($_SESSION[Config::get('session.key', '__')][$key]);
        }
    }
}
