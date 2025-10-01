<?php

declare(strict_types=1);

namespace App\GraphQL\Factory;

use App\Core\Container\Container;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

final class QueryTypeFactory
{
    public static function create(Container $container): ObjectType
    {
        return new ObjectType([
            "name" => "Query",
            "fields" => fn(): array => [
                'sanity_test' => [
                    'type' => Type::string(),
                    'resolve' => fn() => "Schema Works!"
                ]
            ]
        ]);
    }
}
