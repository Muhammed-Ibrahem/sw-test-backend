<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\Domains\Product\Interface\ProductInterface;
use App\Domains\Category\Service\CategoryService;
use App\GraphQL\DataLoader\CategoryLoader;

class CategoryResolver
{
    public function __construct(
        private CategoryService $categoryService,
        private CategoryLoader $categoryLoader
    ) {}

    public function getCategories(): array
    {
        return $this->categoryService->getAllCategories();
    }

    public function getCategory($root, $args)
    {
        $categoryName = $args['name'];

        return $this->categoryService->getCategoryByName($categoryName);
    }

    public function loadProductCategory(ProductInterface $product): Deferred
    {
        $categoryId = $product->getCategoryId();

        $this->categoryLoader->load($categoryId);

        return new Deferred(function () use ($categoryId) {
            $this->categoryLoader->loadBuffered();

            return $this->categoryLoader->getValue($categoryId);
        });
    }
}
