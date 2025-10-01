<?php

declare(strict_types=1);

namespace App\Domains\Category\Entity;

use App\Domains\Category\Entity\Category;

class AllCategory extends Category
{
    private const string categoryName = "all";

    public function __construct(int $id)
    {
        parent::__construct($id, self::categoryName);
    }
}
