<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Domains\Price\Interface\PriceInterface;
use App\GraphQL\Resolvers\CurrencyResolver;
use App\Core\Container\Container;

class PriceType extends ObjectType
{
    public function __construct(private Container $container)
    {
        parent::__construct([
            "name" => "Price",
            "fields" => fn(): array => [
                "id" => [
                    "type" => Type::nonNull(Type::id()),
                    "resolve" => fn(PriceInterface $price): int => $price->getId()
                ],
                "amount" => [
                    "type" => Type::nonNull(Type::float()),
                    "resolve" => fn(PriceInterface $price): float => $price->getAmount()
                ],
                "currency" => [
                    "type" => $container->get(CurrencyType::class),
                    "resolve" => [$container->get(CurrencyResolver::class), "loadPriceCurrency"]

                ],
            ]
        ]);
    }
}
