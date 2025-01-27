<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

use App\Infrastructure\ConnectionInterface;
use PDO;

/**
 * DB connection class
 */
class MysqlConnection implements ConnectionInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $host = getenv('DB_HOST') ?: null;
        $dbname = getenv('MYSQL_DATABASE') ?: null;
        $username = getenv('MYSQL_ROOT_USER') ?: null;
        $password = getenv('MYSQL_ROOT_PASSWORD') ?: null;

        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    public function get(): PDO
    {
        return $this->pdo;
    }
}
