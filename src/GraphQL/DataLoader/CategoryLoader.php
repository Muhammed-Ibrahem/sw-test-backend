<?php

declare(strict_types=1);

namespace App\GraphQL\DataLoader;

use App\Domains\Category\Service\CategoryService;

class CategoryLoader extends Loader
{
    public function __construct(private CategoryService $categoryService) {}

    public function loadBuffered(): void
    {
        $this->loadBatch([$this->categoryService, 'getCategoriesByIds']);
    }
}
