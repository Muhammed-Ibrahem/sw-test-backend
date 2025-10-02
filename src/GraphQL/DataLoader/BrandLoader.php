<?php

declare(strict_types=1);

namespace App\GraphQL\DataLoader;

use App\Domains\Brand\Service\BrandService;

class BrandLoader extends Loader
{
    public function __construct(private BrandService $brandService) {}

    public function loadBuffered(): void
    {
        $this->loadBatch([$this->brandService, 'getBrandsByIds']);
    }
}
