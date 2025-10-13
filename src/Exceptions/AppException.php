<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    protected string $graphqlCode;
    protected int $statusCode;

    public function __construct(string $message = "Something went wrong", int $statusCode = 500, string $graphqlCode = "INTERNAL_SERVER_ERROR", ?Exception $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
        $this->graphqlCode = $graphqlCode;
        $this->statusCode = $statusCode;
    }
}
