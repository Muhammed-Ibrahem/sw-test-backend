<?php

declare(strict_types=1);

namespace App\Domains\Product\Service;

use App\Exceptions\NotFoundException;

use App\Domains\Product\Factory\ProductFactory;
use App\Domains\Product\Interface\ProductInterface;
use App\Domains\Product\Repository\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $repo) {}

    public function getProductById(string $id): ?ProductInterface
    {

        $row = $this->repo->findById($id);
        if (! $row) {
            throw new NotFoundException("Product not found");
        };

        $product = $this->createProductFromDBRow($row);

        return $product;
    }

    public function getAllProducts(): array
    {
        $rows = $this->repo->findAll();

        $products = $this->createProductsFromDBRows($rows);

        return $products;
    }

    public function getProductsByCategoryIds(array $categoryIds): array
    {

        $rows = $this->repo->findByCategoryIds($categoryIds);

        $map = $this->createGroupedProducts($rows, 'category_id');

        foreach ($categoryIds as $id) {
            if (! isset($map[$id])) {
                $map[$id] = [];
            }
        }

        return $map;
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
