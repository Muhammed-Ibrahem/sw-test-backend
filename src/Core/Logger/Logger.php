<?php

declare(strict_types=1);

namespace App\Core\Logger;

use App\Core\Logger\LoggerInterface;

final class Logger implements LoggerInterface
{
    public static function log(string $message): void
    {
        error_log($message);
    }
}
