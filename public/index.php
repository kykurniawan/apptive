<?php

use Apptive\Core\Brains\App;

define('ROOT_PATH', realpath(dirname(__DIR__)));
define('CORE_PATH', ROOT_PATH . '/core');
define('APP_PATH', ROOT_PATH . '/app');

require_once CORE_PATH . '/bootstrap/app.php';

App::loadCoreModule('database');

App::start();
