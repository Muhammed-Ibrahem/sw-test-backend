<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\Domains\Category\Interface\CategoryInterface;
use App\Domains\Product\Interface\ProductInterface;
use App\Domains\Product\Service\ProductService;
use App\GraphQL\DataLoader\ProductLoader;

class ProductResolver
{
    public function __construct(
        private ProductService $srv,
        private ProductLoader $productLoader,
    ) {}

    public function getProductById(string $id): ?ProductInterface
    {
        return $this->srv->getProductById($id);
    }

    public function getAllProducts(): array
    {
        return $this->srv->getAllProducts();
    }

    public function loadProductsForEachCategory(CategoryInterface $category): Deferred
    {
        $categoryId = $category->getId();

        $this->productLoader->load($categoryId);

        return new Deferred(function () use ($categoryId) {
            $this->productLoader->loadBuffered();

            return $this->productLoader->getValue($categoryId);
        });
    }
}
