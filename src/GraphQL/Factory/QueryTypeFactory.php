<?php

declare(strict_types=1);

namespace App\GraphQL\Factory;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Domains\Product\Interface\ProductInterface;
use App\GraphQL\Resolvers\CategoryResolver;
use App\GraphQL\Resolvers\ProductResolver;
use App\GraphQL\Types\CategoryType;
use App\GraphQL\Types\ProductType;
use App\Core\Container\Container;

final class QueryTypeFactory
{
    public static function create(Container $container): ObjectType
    {
        return new ObjectType([
            "name" => "Query",
            "fields" => fn(): array => [
                "categories" => [
                    "type" => Type::listOf($container->get(CategoryType::class)),
                    "resolve" => [$container->get(CategoryResolver::class), "getCategories"],
                ],
                "product" => [
                    "type" => $container->get(ProductType::class),
                    "args" => [
                        "id" => Type::nonNull(Type::id())
                    ],
                    "resolve" => fn($root, $args): ?ProductInterface => $container->get(ProductResolver::class)->getProductById($args['id']),
                ],
                "products" => [
                    "type" => Type::listOf($container->get(ProductType::class)),
                    "resolve" =>  [$container->get(ProductResolver::class), "getAllProducts"]
                ]
            ]
        ]);
    }
}
