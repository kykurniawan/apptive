<?php

namespace Apptive\Core\Brains;

class Flash
{
    public static function set(string $key, $value)
    {
        Session::set(Config::get('session.flash_key', '_flash'), [$key => $value]);
    }

    public static function get(string $key)
    {
        if (Session::get(Config::get('session.flash_key', '_flash'))) {
            if (isset(Session::get(Config::get('session.flash_key', '_flash'))[$key])) {
                return Session::get(Config::get('session.flash_key', '_flash'))[$key];
            }
        }

        return null;
    }

    public static function clear()
    {
        if (Session::get(Config::get('session.flash_key', '_flash'))) {
            Session::delete(Config::get('session.flash_key', '_flash'));
        }
    }
}
