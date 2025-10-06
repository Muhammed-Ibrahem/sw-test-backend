<?php

declare(strict_types=1);

namespace App\Domains\Category\Factory;

use App\Domains\Category\Interface\CategoryInterface;
use App\Domains\Category\Factory\CategoryFactory;
use App\Domains\Category\Entity\AllCategory;

class AllCategoryFactory extends CategoryFactory
{
    public function createCategory(int $id): CategoryInterface
    {
        return new AllCategory($id);
    }
}
