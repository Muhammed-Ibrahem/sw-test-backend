<?php

declare(strict_types=1);

namespace App\Config;

final class Config
{
    protected $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host' => $env['DB_HOST'],
                'user' => $env['DB_USER'],
                'pass' => $env['DB_PASS'],
                'database' => $env['DB_DATABASE'],
                'port' => $env['DB_PORT'],
                'driver' => $env['DB_DRIVER'] ?? 'mysql',
            ]
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
