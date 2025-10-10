<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\AppException;

class DatabaseException extends AppException
{
    public function __construct(string $message = 'Database error')
    {
        parent::__construct($message, 500, "DATABASE_ERROR");
    }
}
