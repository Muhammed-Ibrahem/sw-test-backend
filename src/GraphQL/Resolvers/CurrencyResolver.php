<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\Domains\Price\Interface\PriceInterface;
use App\GraphQL\DataLoader\CurrencyLoader;

class CurrencyResolver
{
    public function __construct(
        private CurrencyLoader $currencyLoader
    ) {}

    public function loadPriceCurrency(PriceInterface $price): Deferred
    {
        $this->currencyLoader->load($price->getCurrencyId());

        return new Deferred(function () use ($price) {
            $this->currencyLoader->loadBuffered();

            return $this->currencyLoader->getValue($price->getCurrencyId());
        });
    }
}
