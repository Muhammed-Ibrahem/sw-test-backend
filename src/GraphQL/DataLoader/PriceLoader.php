<?php

declare(strict_types=1);

namespace App\GraphQL\DataLoader;

use App\Domains\Price\Service\PriceService;

class PriceLoader extends Loader
{
    public function __construct(private PriceService $priceService) {}

    public function  loadBuffered(): void
    {
        $this->loadBatch([$this->priceService, 'getPricesByProductIds']);
    }
}
