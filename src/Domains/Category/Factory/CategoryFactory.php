<?php

declare(strict_types=1);

namespace App\Domains\Category\Factory;

use App\Domains\Category\Interface\CategoryInterface;
use App\Domains\Category\Entity\Category;

class CategoryFactory
{
    public static function createCategory(int $id, string $name): CategoryInterface
    {
        return new Category($id, $name);
    }
}
