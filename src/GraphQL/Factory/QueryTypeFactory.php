<?php

declare(strict_types=1);

namespace App\GraphQL\Factory;

use App\Core\Container\Container;
use App\GraphQL\Resolvers\CategoryResolver;
use App\GraphQL\Types\CategoryType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

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
            ]
        ]);
    }
}
