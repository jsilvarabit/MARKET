<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            $config = require dirname(__DIR__, 2) . '/config/database.php';

            self::$connection = new PDO('sqlite:' . $config['database']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return self::$connection;
    }
}
