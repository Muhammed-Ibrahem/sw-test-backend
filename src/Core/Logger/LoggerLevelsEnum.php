<?php

declare(strict_types=1);

namespace App\Core\Logger;

enum LoggerLevelsEnum: string
{
    case DEBUG = "\033[0;36m[DEBUG]\033[0m";    // cyan

    case INFO = "\033[0;32m[INFO]\033[0m";      // green

    case NOTICE = "\033[0;34m[NOTICE]\033[0m";  // blue

    case WARNING = "\033[1;33m[WARNING]\033[0m"; // yellow

    case ERROR = "\033[0;31m[ERROR]\033[0m";    // red

    case CRITICAL = "\033[1;31m[CRITICAL]\033[0m"; // bright red
}
