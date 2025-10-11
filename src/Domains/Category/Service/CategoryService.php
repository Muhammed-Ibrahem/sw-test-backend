<?php

declare(strict_types=1);

namespace App\Domains\Category\Service;

use App\Exceptions\NotFoundException;

use App\Domains\Category\Repository\CategoryRepository;
use App\Domains\Category\Interface\CategoryInterface;
use App\Domains\Category\Factory\CategoryFactory;

final class CategoryService
{
    public function __construct(private CategoryRepository $repo) {}

    public function getAllCategories(): array
    {
        $rows = $this->repo->getAll();

        $categories = $this->createCategoriesFromDBRows($rows);

        return $categories;
    }

    public function getCategoriesByIds(array $categoryIds): array
    {

        $rows = $this->repo->findByIds($categoryIds);

        $categories = $this->createCategoriesGroupedById($rows);

        return $categories;
    }

    public function getCategoryByName(string $categoryName)
    {

        $row = $this->repo->findByName($categoryName);

        if (!$row) {
            throw new NotFoundException("Category Not Found");
        }

        $category = $this->createCategoryFromDBRow($row);
        return $category;
    }
    private function createCategoryFromDBRow(array $row): CategoryInterface
    {
        $categoryName = $row['name'];
        $categoryId = $row['id'];

        return CategoryFactory::createCategory($categoryId, $categoryName);
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
