<?php

namespace App\Database;

use PDO;

class Connection
{
    public PDO $pdo;

    public function __construct()
    {
        $local_mode = getenv('LOCAL_MODE');

        $host = 'localhost';
        if ($local_mode === '0') {
            $host = getenv('DB_HOST');
        }

        $dns = 'pgsql:host=' . $host . ';dbname=' . getenv('DB_NAME');


        $this->pdo = new PDO(
            $dns,
            getenv('DB_USER'),
            getenv('DB_PASSWORD'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}
