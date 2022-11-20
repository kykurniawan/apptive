<?php

namespace Apptive\Core\Modules\Database;

use Apptive\Core\Brains\Config;

class Database
{
    private static ?\PDO $connection = null;

    private function __construct()
    {
        // Not implemented
    }

    public static function getConnection(): \PDO
    {
        try {
            if (self::$connection === null) {
                $host = Config::get('database.host', 'localhost');
                $port = Config::get('database.port', 3306);
                $database = Config::get('database.database', 'apptive');
                $user = Config::get('database.user', 'root');
                $password = Config::get('database.password', 'root');

                self::$connection = new \PDO('mysql:host=' . $host . ':' . $port . ';dbname=' . $database, $user, $password);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            return self::$connection;
        } catch (\PDOException $th) {
            throw $th;
        }
    }

    public static function begin()
    {
        return self::getConnection()->beginTransaction();
    }

    public static function commit()
    {
        return self::getConnection()->commit();
    }

    public static function rollback()
    {
        return self::getConnection()->rollBack();
    }
}
