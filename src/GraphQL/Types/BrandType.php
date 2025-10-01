<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Domains\Brand\Interface\BrandInterface;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class BrandType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            "name" => "Brand",
            "fields" => fn(): array => [
                "id" => [
                    "type" => Type::nonNull(Type::id()),
                    "resolve" => fn(BrandInterface $brand): int => $brand->getId()
                ],
                "name" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(BrandInterface $brand): string => $brand->getName(),
                ],
            ],
        ]);
    }
}
