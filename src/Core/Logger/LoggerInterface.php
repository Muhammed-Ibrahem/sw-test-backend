<?php

declare(strict_types=1);

namespace App\Core\Logger;

use App\Core\Logger\LoggerLevelsEnum;

interface LoggerInterface
{
    public static function log(string $message, LoggerLevelsEnum $level): void;
}
