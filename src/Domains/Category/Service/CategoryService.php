<?php

declare(strict_types=1);

namespace App\Domains\Category\Service;

use Exception;

use App\Domains\Category\Repository\CategoryRepository;
use App\Domains\Category\Interface\CategoryInterface;
use App\Domains\Category\Enum\CategoryEnum;

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

    public function getCategoriesByIds(array $categoryIds): array
    {
        try {
            $rows = $this->repo->findByIds($categoryIds);

            $categories = $this->createCategoriesGroupedById($rows);

            return $categories;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve categories: {$e->getMessage()}");
        }
    }

    public function getCategoryByName(string $categoryName)
    {
        try {
            $row = $this->repo->findByName($categoryName);

            $category = $this->createCategoryFromDBRow($row);

            return $category;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve categories: {$e->getMessage()}");
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

    private function createCategoriesGroupedById(array $rows): array
    {
        $groupedCategories = [];

        foreach ($rows as $row) {
            $groupedCategories[$row['id']] = $this->createCategoryFromDBRow($row);
        }

        return $groupedCategories;
    }
}
