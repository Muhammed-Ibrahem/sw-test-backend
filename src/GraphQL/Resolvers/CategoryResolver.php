<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Domains\Category\Service\CategoryService;

class CategoryResolver
{
    public function __construct(private CategoryService $srv) {}

    public function getCategories(): array
    {
        return $this->srv->getAllCategories();
    }
}
