<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Core\Container\Container;
use App\Domains\Gallery\Service\GalleryService;
use App\Domains\Product\Interface\ProductInterface;
use App\GraphQL\DataLoader\GalleryLoader;
use GraphQL\Deferred;

class GalleryResolver
{
    public function __construct(
        private GalleryService $galleryService,
        private Container $container
    ) {}

    public function getGalleryByProductIds(ProductInterface $product): Deferred
    {
        $galleryLoader = $this->container->get(GalleryLoader::class);

        $galleryLoader->load($product->getId());

        return new Deferred(function () use ($galleryLoader, $product) {
            $galleryLoader->loadBuffered();

            return $galleryLoader->getValue($product->getId());
        });
    }
}
