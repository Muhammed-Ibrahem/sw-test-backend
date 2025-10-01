<?php

declare(strict_types=1);

namespace App\Domains\Category\Entity;

use App\Domains\Category\Entity\Category;

class TechCategory extends Category
{
    private const string categoryName = "tech";

    public function __construct(int $id)
    {
        parent::__construct($id, self::categoryName);
    }
}
