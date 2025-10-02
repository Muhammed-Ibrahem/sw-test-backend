<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Domains\Attribute\Interface\AttributeInterface;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            "name" => "Attribute",
            "fields" => fn(): array => [
                "id" => [
                    "type" => Type::nonNull(Type::id()),
                    "resolve" => fn(AttributeInterface $attr): string => $attr->getId(),
                ],
                "displayValue" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(AttributeInterface $attr): string => $attr->getDisplayValue()
                ],
                "value" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(AttributeInterface $attr): string => $attr->getValue()
                ]
            ]
        ]);
    }
}
