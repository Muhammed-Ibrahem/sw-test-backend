<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\Domains\Product\Interface\ProductInterface;
use App\Domains\Brand\Service\BrandService;
use App\GraphQL\DataLoader\BrandLoader;
use App\Core\Container\Container;

class BrandResolver
{
    public function __construct(
        private BrandService $brandService,
        private Container $container
    ) {}

    public function loadProductBrand(ProductInterface $product): Deferred
    {
        $brandLoader = $this->container->get(BrandLoader::class);

        $brandLoader->load($product->getBrandId());

        return new Deferred(function () use ($brandLoader, $product) {
            $brandLoader->loadBuffered();

            return $brandLoader->getValue($product->getBrandId());
        });
    }
}
