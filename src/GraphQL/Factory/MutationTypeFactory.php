<?php

declare(strict_types=1);

namespace App\GraphQL\Factory;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Core\Container\Container;

final class MutationTypeFactory
{
    public static function create(Container $container): ObjectType
    {
        return new ObjectType([
            "name" => "Mutation",
            "fields" => fn() => [
                "sum" => [
                    "type" => Type::int(),
                    "args" => [
                        "x" => ["type" => Type::int()],
                        "y" => ["type" => Type::int()],
                    ],
                    "resolve" => fn($calc, array $args) => $args["x"] + $args["y"]
                ],
            ]
        ]);
    }
}
