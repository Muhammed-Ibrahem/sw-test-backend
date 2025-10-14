<?php

declare(strict_types=1);

namespace App\Core\Logger;

use App\Core\Logger\LoggerInterface;

use App\Core\Logger\LoggerLevelsEnum;

final class Logger implements LoggerInterface
{

    public static function log(string $message, LoggerLevelsEnum $level): void
    {
        $timestamp = date("Y-m-d H:i:s");

        $formattedMessage = sprintf("[%s] %s %s", $timestamp, $level->value, $message);

        error_log($formattedMessage);
    }
}
