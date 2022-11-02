<?php

if (!function_exists('flash')) {
    function flash($key)
    {
        if (isset($_SESSION[config('session.flash_key', '_flash')])) {
            if (isset($_SESSION[config('session.flash_key', '_flash')][$key])) {
                return $_SESSION[config('session.flash_key', '_flash')][$key];
            }
        }
        return null;
    }
}

if (!function_exists('set_flash')) {
    function set_flash($key, $value)
    {
        $_SESSION[config('session.flash_key', '_flash')][$key] = $value;
    }
}

if (!function_exists('old')) {
    function old($key, $default = null)
    {
        $result = flash('old__' . $key);
        if ($result == null) {
            return $default;
        }
        return $result;
    }
}

if (!function_exists('clear_flash')) {
    function clear_flash()
    {
        if (isset($_SESSION[config('session.flash_key', '_flash')])) {
            unset($_SESSION[config('session.flash_key', '_flash')]);
        }
    }
}

if (!function_exists('config')) {
    function config($key, $default = null)
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

if (!function_exists('app_modules')) {
    function app_modules($modules = [])
    {
        foreach ($modules as $module) {
            if (!file_exists(APP_PATH . '/modules/' . $module . '/index.php')) {
                throw new Error('Cannot load module: ' . $module . ', make sure you have create that module.');
            }

            require_once APP_PATH . '/modules/' . $module . '/index.php';
        }
    }
}

if (!function_exists('core_modules')) {
    function core_modules($coreModules = [])
    {
        foreach ($coreModules as $module) {
            if (!file_exists(CORE_PATH . '/modules/' . $module . '/index.php')) {
                throw new Error('Cannot load module: ' . $module . ':: core module not found.');
            }

            require_once CORE_PATH . '/modules/' . $module . '/index.php';
        }
    }
}

if (!function_exists('when_page')) {
    function when_page($page, Closure $callback)
    {
        if ($_GET[config('app.page_key', 'page')] === $page) {
            $callback();
            clear_flash();
            exit();
        }
    }
}

if (!function_exists('load_page')) {
    function load_page($path, $context = [], $layout = 'default')
    {
        extract($context);
        define('PAGE_FILE', APP_PATH . '/resources/pages/' . $path . '.php');
        if (!file_exists(PAGE_FILE)) {
            throw new Error('Page file not found');
        }
        define('LAYOUT_FILE', APP_PATH . '/resources/layouts/' . $layout . '.php');
        if (!file_exists(LAYOUT_FILE)) {
            throw new Error('Layout page file not found');
        }

        include LAYOUT_FILE;
    }
}

if (!function_exists('part')) {
    function part($part)
    {
        if (!file_exists(APP_PATH . '/resources/parts/' . $part . '.php')) {
            throw new Error('View part not found');
        }

        return APP_PATH . '/resources/parts/' . $part . '.php';;
    }
}

if (!function_exists('url')) {
    function url($page, $query = [])
    {
        $query[config('app.page_key', 'page')] = $page;
        return config('app.base_url', 'http://127.0.0.1/') . '?' . http_build_query($query);
    }
}

if (!function_exists('redirect')) {
    function redirect($page, $query = [], $permanent = false)
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: ' . url($page, $query));
        exit;
    }
}

if (!function_exists('method')) {
    function method($method = null)
    {
        if ($method) {
            if (strtolower($method) === strtolower($_SERVER['REQUEST_METHOD'])) {
                return true;
            }
            return false;
        }
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}

if (!function_exists('query')) {
    function query($key = null)
    {
        if ($key) {
            if (isset($_GET[$key])) {
                return $_GET[$key];
            }
            return null;
        }
        return $_GET;
    }
}

if (!function_exists('start_app')) {
    function start_app(Closure $errorHandler = null)
    {
        try {
            if (!isset($_GET[config('app.page_key', 'page')]) || $_GET[config('app.page_key', 'page')] == '') {
                header('Location: ' . config('app.base_url', 'http://127.0.0.1/') . '?' . config('app.page_key', 'page') . '=' . config('app.default_page', 'home'));
                exit;
            }
            require_once APP_PATH . '/routers/main.php';
            clear_flash();
            throw new PageNotFoundException();
        } catch (\Throwable $th) {
            if (is_null($errorHandler)) {
                error_handler($th);
            } else {
                $errorHandler($th);
            }
        }
    }
}
