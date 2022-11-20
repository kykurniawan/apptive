<?php

use Apptive\Core\Modules\Database\Database;

require_once 'Database.php';

if (!function_exists('database')) {
    function database()
    {
        return Database::getConnection();
    }
}
