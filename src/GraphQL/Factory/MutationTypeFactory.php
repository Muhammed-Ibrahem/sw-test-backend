<?php

declare(strict_types=1);

namespace App\GraphQL\Factory;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\GraphQL\InputTypes\OrderItemInputType;
use App\GraphQL\Resolvers\OrderResolver;
use App\Core\Container\Container;

final class MutationTypeFactory
{
    public static function create(Container $container): ObjectType
    {
        return new ObjectType([
            "name" => "Mutation",
            "fields" => fn() => [
                "placeOrder" => [
                    "type" => Type::nonNull(Type::int()),
                    "args" => [
                        "orderItems" => Type::nonNull(
                            Type::listOf(
                                Type::nonNull($container->get(OrderItemInputType::class))
                            )
                        )
                    ],
                    "resolve" => [$container->get(OrderResolver::class), 'placeOrder']
                ]
            ]
        ]);
    }
}
