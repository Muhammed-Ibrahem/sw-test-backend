<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\GraphQL\Resolvers\AttributeResolver;
use App\GraphQL\Types\AttributeType;
use App\Core\Container\Container;

class AttributeSetType extends ObjectType
{
    public function __construct(private Container $container)
    {
        parent::__construct([
            "name" => "AttributeSet",
            "fields" => fn(): array => [
                "id" => [
                    "type" => Type::nonNull(Type::id()),
                    "resolve" => fn(array $parent): string => $parent['attributeSet']->getId()
                ],
                "name" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(array $parent): string =>  $parent['attributeSet']->getName()
                ],
                "type" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(array $parent): string => $parent['attributeSet']->getType()
                ],
                "items" => [
                    "type" => Type::listOf($container->get(AttributeType::class)),
                    "resolve" => [$container->get(AttributeResolver::class), "loadAttributes"]
                ]
            ]
        ]);
    }
}
