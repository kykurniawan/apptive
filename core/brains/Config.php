<?php

namespace Apptive\Core\Brains;

class Config
{
    public static function get(string $key, $default = null)
    {
        $array = explode('.', $key);

        $configFile = APP_PATH . '/configs/' . $array[0] . '.php';

        if (!file_exists($configFile)) {
            return $default;
        }

        if (sizeof($array) === 1) {
            return require $configFile;
        } else {
            unset($array[0]);
            $key = implode('.', $array);
            $current = require $configFile;;
            $p = strtok($key, '.');
            while ($p !== false) {
                if (!isset($current[$p])) {
                    return $default;
                }
                $current = $current[$p];
                $p = strtok('.');
            }
            return $current;
        }
    }
}
