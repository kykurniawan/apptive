<?php
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
                $host = config('database.host', 'localhost');
                $port = config('database.port', 3306);
                $database = config('database.database', 'apptive');
                $user = config('database.user', 'root');
                $password = config('database.password', 'root');

                self::$connection = new \PDO('mysql:host=' . $host . ':' . $port . ';dbname=' . $database, $user, $password);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            return self::$connection;
        } catch (\PDOException $th) {
            throw $th;
        }
    }
}

if (!function_exists('database')) {
    function database()
    {
        return Database::getConnection();
    }
}
