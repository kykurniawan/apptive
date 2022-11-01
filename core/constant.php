<?php
defined('APP') or exit('Access denied');

define('ROOT_PATH', realpath(dirname(__DIR__)));

define('CORE_PATH', ROOT_PATH . '/core');

define('APP_PATH', ROOT_PATH . '/app');

define('DATABASE', APP_PATH . '/core/libs/Database.php');

define('VALIDATOR', APP_PATH . '/core/libs/Validator.php');
