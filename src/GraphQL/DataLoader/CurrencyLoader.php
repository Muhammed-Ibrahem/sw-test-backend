<?php

declare(strict_types=1);

namespace App\GraphQL\DataLoader;

use App\Domains\Currency\Service\CurrencyService;

class CurrencyLoader extends Loader
{
    public function __construct(
        private CurrencyService $currencyService
    ) {}

    public function loadBuffered(): void
    {
        $this->loadBatch([$this->currencyService, "findCurrencyByIds"]);
    }
}
