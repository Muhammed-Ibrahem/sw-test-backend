<?php

declare(strict_types=1);

namespace App\GraphQL\InputTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use App\GraphQL\InputTypes\OrderItemAttributeInputType;
use App\Core\Container\Container;

class OrderItemInputType extends InputObjectType
{
    public function __construct(private Container $container)
    {
        parent::__construct([
            "name" => "OrderItemInput",
            "fields" => [
                "productId" => Type::nonNull(Type::id()),
                "quantity" => Type::nonNull(Type::int()),
                "unitPrice" => Type::nonNull(Type::float()),
                "currencyId" => Type::nonNull(Type::int()),
                "attributes" => Type::listOf($container->get(OrderItemAttributeInputType::class))
            ]
        ]);
    }
}
