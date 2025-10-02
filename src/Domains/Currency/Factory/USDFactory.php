<?php

declare(strict_types=1);

namespace App\Domains\Currency\Factory;

use App\Domains\Currency\Interface\CurrencyInterface;
use App\Domains\Currency\Factory\CurrencyFactory;
use App\Domains\Currency\Entity\USD;

class USDFactory extends CurrencyFactory
{
    public function createCurrency(int $id): CurrencyInterface
    {
        return new USD($id);
    }
}
