<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Domains\Gallery\Interface\GalleryInterface;

class GalleryType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => "Gallery",
            'fields' => fn() => [
                'id' => [
                    'type' => Type::nonNull(Type::id()),
                    'resolve' => fn(GalleryInterface $gallery): int => $gallery->getId(),
                ],
                'url' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn(GalleryInterface $gallery): string => $gallery->getUrl(),
                ],
                'productId' => [
                    'type' => Type::nonNull(Type::string()),
                    'resolve' => fn(GalleryInterface $gallery): string => $gallery->getProductId()
                ]
            ]
        ]);
    }
}
