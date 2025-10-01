<?php

namespace App\Core\Database;

use PDO;
use PDOException;

use RuntimeException;

final class Database
{
    private ?PDO $connection = null;

    private array $defaultOptions = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function __construct(protected array $config)
    {
        try {
            $dbHost = $config['host'];
            $dbName = $config['database'];
            $dbDriver = $config['driver'];
            $dbPort = $config['port'];

            $dsn = "{$dbDriver}:host={$dbHost};port={$dbPort};dbname={$dbName}";

            $username = $config['user'];
            $password = $config['pass'];

            $options = $config['options'] ?? $this->defaultOptions;


            $this->connection = new PDO(
                dsn: $dsn,
                username: $username,
                password: $password,
                options: $options
            );
        } catch (PDOException $e) {
            throw new RuntimeException("Database Connection Error: {$e->getMessage()}");
        }
    }

    public function disconnect()
    {
        $this->connection = null;
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            throw new RuntimeException("Database Connection Error");
        }

        return $this->connection;
    }
}
