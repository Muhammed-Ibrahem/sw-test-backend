<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Domains\Product\Interface\ProductInterface;
use App\Core\Container\Container;

class ProductType extends ObjectType
{
    public function __construct(private Container $container)
    {
        parent::__construct([
            "name" => "Product",
            "fields" => fn(): array => [
                "id" => [
                    "type" => Type::nonNull(Type::id()),
                    "resolve" => fn(ProductInterface $product): string => $product->getId(),
                ],
                "name" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(ProductInterface $product) => $product->getName(),
                ],
                "inStock" => [
                    "type" => Type::nonNull(Type::boolean()),
                    "resolve" => fn(ProductInterface $product) => $product->isInStock()
                ],
                "description" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(ProductInterface $product) => $product->getDescription(),
                ],
                "category" => [
                    "type" => $container->get(CategoryType::class),
                    "description" => "To be implemented!!! by dataloaders",
                    "resolve" => fn() => []
                ],
                "brand" => [
                    "type" => Type::string(),
                    "resolve" => fn() => "To be implemented!!! by dataloaders"
                ],
                "attributes" => [
                    "type" => Type::string(),
                    "resolve" => fn() => "To be implemented!!! by dataloaders"
                ]
            ]
        ]);
    }
}
