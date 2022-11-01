<?php
defined('APP') or exit('Access denied');

return [
    'app_name' => 'Apptive',
    'base_url' => 'http://127.0.0.1/apptive/',
    'default_page' => 'home',
    'page_key' => 'page',
    'flash_key' => '_flash',
    'modules_path' => APP_PATH . '/modules',
    'resources_path' => APP_PATH . '/resources',
    'routers_path' => APP_PATH . '/routers',
    'database' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'apptive',
        'user' => 'root',
        'password' => 'root'
    ]
];
