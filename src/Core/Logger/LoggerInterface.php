<?php

declare(strict_types=1);

namespace App\Core\Logger;

interface LoggerInterface
{
    public static function log(string $message): void;
}
