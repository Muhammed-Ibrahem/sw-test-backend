<?php

declare(strict_types=1);

namespace App\Domains\Category\Factory;

use App\Domains\Category\Interface\CategoryInterface;

abstract class CategoryFactory
{
    abstract public function createCategory(int $id): CategoryInterface;
}
