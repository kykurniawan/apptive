<?php

namespace Apptive\Core\Brains;

use \Closure;
use \Error;
use Apptive\Core\Brains\Config;

class App
{
    const VERSION = '0.1.0';

    public static function start(Closure $errorHandler = null)
    {
        session_start();

        try {
            if (!isset($_GET[Config::get('app.page_key', 'page')]) || $_GET[Config::get('app.page_key', 'page')] == '') {
                header('Location: ' . Config::get('app.base_url', 'http://127.0.0.1/') . '?' . Config::get('app.page_key', 'page') . '=' . Config::get('app.default_page', 'home'));
                exit;
            }
            require_once APP_PATH . '/routers/main.php';
            Flash::clear();
            Ups::pageNotFound();
        } catch (\Throwable $th) {
            if (is_null($errorHandler)) {
                Ups::handler($th);
            } else {
                $errorHandler($th);
            }
        }
    }

    public static function loadCoreModule($module)
    {
        if (!file_exists(CORE_PATH . '/modules/' . $module . '/index.php')) {
            throw new Error('Cannot load module: ' . $module . ':: core module not found.');
        }

        require_once CORE_PATH . '/modules/' . $module . '/index.php';
    }

    public static function loadModule($module)
    {
        if (!file_exists(APP_PATH . '/modules/' . $module . '/index.php')) {
            throw new Error('Cannot load module: ' . $module . ', make sure you have create that module.');
        }

        require_once APP_PATH . '/modules/' . $module . '/index.php';
    }
}
