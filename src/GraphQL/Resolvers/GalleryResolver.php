<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\Domains\Product\Interface\ProductInterface;
use App\Domains\Gallery\Service\GalleryService;
use App\GraphQL\DataLoader\GalleryLoader;

class GalleryResolver
{
    public function __construct(
        private GalleryService $galleryService,
        private GalleryLoader $galleryLoader
    ) {}

    public function getGalleryByProductIds(ProductInterface $product): Deferred
    {
        $productId = $product->getId();

        $this->galleryLoader->load($productId);

        return new Deferred(function () use ($productId) {
            $this->galleryLoader->loadBuffered();

            return $this->galleryLoader->getValue($productId);
        });
    }
}
