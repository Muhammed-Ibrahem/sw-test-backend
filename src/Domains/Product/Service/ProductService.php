<?php

declare(strict_types=1);

namespace App\Domains\Product\Service;

use Exception;

use App\Domains\Product\Factory\ProductFactory;
use App\Domains\Product\Interface\ProductInterface;
use App\Domains\Product\Repository\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $repo) {}

    public function getProductById(string $id): ?ProductInterface
    {
        try {
            $row = $this->repo->findById($id);
            if (! $row) return null;

            $product = $this->createProductFromDBRow($row);

            return $product;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve product: {$e->getMessage()}");
        }
    }

    public function getAllProducts(): array
    {
        try {
            $rows = $this->repo->findAll();

            $products = $this->createProductsFromDBRows($rows);

            return $products;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve products: {$e->getMessage()}");
        }
    }

    public function getProductsByCategoryIds(array $categoryIds): array
    {
        try {
            $rows = $this->repo->findByCategoryIds($categoryIds);

            $map = $this->createGroupedProducts($rows, 'category_id');

            foreach ($categoryIds as $id) {
                if (! isset($map[$id])) {
                    $map[$id] = [];
                }
            }

            return $map;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve products: {$e->getMessage()}");
        }
    }

    private function createProductFromDBRow(array $row)
    {
        $id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
        $inStock = $row['in_stock'];
        $categoryId = $row['category_id'];
        $brandId = $row['brand_id'];

        $product = ProductFactory::createProduct(
            id: $id,
            name: $name,
            inStock: (bool) $inStock,
            description: $description,
            categoryId: $categoryId,
            brandId: $brandId
        );

        return $product;
    }

    private function createProductsFromDBRows(array $rows): array
    {
        $products = [];

        foreach ($rows as $row) {
            $product = $this->createProductFromDBRow($row);
            $products[] = $product;
        }

        return $products;
    }

    private function createGroupedProducts(array $rows, string $groupingKey): array
    {
        $groupedProducts = [];

        foreach ($rows as $row) {
            $groupedProducts[$row[$groupingKey]][] = $this->createProductFromDBRow($row);
        }

        return $groupedProducts;
    }
}
