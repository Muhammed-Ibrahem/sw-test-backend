<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Core\Container\Container;
use App\Domains\Category\Interface\CategoryInterface;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CategoryType extends ObjectType
{
    public function __construct(private Container $container)
    {
        parent::__construct([
            "name" => "Category",
            "fields" => fn(): array => [
                "id" => [
                    "type" => Type::nonNull(Type::id()),
                    "resolve" => fn(CategoryInterface $category): int => $category->getId(),
                ],
                "name" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(CategoryInterface $category): string => $category->getName(),
                ],
                "products" => [
                    "type" => Type::listOf(Type::string()),
                    "description" => "To be implemented!!!",
                    "resolve" => fn(): array => []
                ]
            ]
        ]);
    }
}
