<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Domains\Category\Interface\CategoryInterface;
use App\Domains\Product\Interface\ProductInterface;
use App\Domains\Product\Service\ProductService;
use App\GraphQL\DataLoader\ProductLoader;
use App\Core\Container\Container;
use GraphQL\Deferred;

class ProductResolver
{
    public function __construct(private ProductService $srv, private Container $container) {}

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
        $productsLoader = $this->container->get(ProductLoader::class);
        $productsLoader->load($category->getId());

        return new Deferred(function () use ($productsLoader, $category) {
            $productsLoader->loadBuffered();

            return $productsLoader->getValue($category->getId());
        });
    }
}
