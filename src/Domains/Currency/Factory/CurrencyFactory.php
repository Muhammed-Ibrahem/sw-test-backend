<?php

namespace App\Domains\Currency\Factory;

use App\Domains\Currency\Interface\CurrencyInterface;

abstract class CurrencyFactory
{
    abstract public function createCurrency(int $id): CurrencyInterface;
}
