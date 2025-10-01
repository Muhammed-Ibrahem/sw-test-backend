<?php

declare(strict_types=1);

namespace App\Domains\Category\Service;

use Exception;

use App\Domains\Category\Enum\CategoryEnum;
use App\Domains\Category\Interface\CategoryInterface;
use App\Domains\Category\Repository\CategoryRepository;

final class CategoryService
{
    public function __construct(private CategoryRepository $repo) {}

    public function getAllCategories(): array
    {
        try {
            $rows = $this->repo->getAll();

            $categories = $this->createCategoriesFromDBRows($rows);

            return $categories;
        } catch (Exception $e) {
            throw new Exception("Failed to fetch categories: {$e->getMessage()}");
        }
    }


    private function createCategoryFromDBRow(array $row): CategoryInterface
    {
        $categoryName = $row['name'];
        $categoryId = $row['id'];

        return CategoryEnum::from($categoryName)->getFactory()->createCategory($categoryId);
    }
    private function createCategoriesFromDBRows(array $rows): array
    {
        $categories = [];

        foreach ($rows as $row) {
            $categories[] = $this->createCategoryFromDBRow($row);
        }

        return $categories;
    }
}
