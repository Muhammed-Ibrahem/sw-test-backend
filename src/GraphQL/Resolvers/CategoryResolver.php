<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Core\Container\Container;
use App\Domains\Category\Service\CategoryService;
use App\Domains\Product\Interface\ProductInterface;
use App\GraphQL\DataLoader\CategoryLoader;
use GraphQL\Deferred;

class CategoryResolver
{
    public function __construct(
        private CategoryService $categoryService,
        private Container $container
    ) {}

    public function getCategories(): array
    {
        return $this->categoryService->getAllCategories();
    }

    public function loadProductCategory(ProductInterface $product): Deferred
    {
        $categoryLoader = $this->container->get(CategoryLoader::class);

        $categoryLoader->load($product->getCategoryId());

        return new Deferred(function () use ($categoryLoader, $product) {
            $categoryLoader->loadBuffered();

            return $categoryLoader->getValue($product->getCategoryId());
        });
    }
}
