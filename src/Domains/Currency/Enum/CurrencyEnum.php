<?php

declare(strict_types=1);

namespace App\Domains\Currency\Enum;

use App\Domains\Currency\Factory\USDFactory;

enum CurrencyEnum: string
{
    case USD = "USD";

    public  function getFactory()
    {
        return match ($this) {
            self::USD => new USDFactory()
        };
    }
}
