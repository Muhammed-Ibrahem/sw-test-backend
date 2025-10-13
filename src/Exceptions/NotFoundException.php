<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\AppException;

class NotFoundException extends AppException
{
    public function __construct(string $message = 'Resource not found')
    {
        parent::__construct($message, 404, "NOT_FOUND");
    }
}
