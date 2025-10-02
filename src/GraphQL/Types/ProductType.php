<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Domains\Product\Interface\ProductInterface;
use App\Core\Container\Container;

use App\GraphQL\Types\CategoryType;
use App\GraphQL\Types\GalleryType;
use App\GraphQL\Types\BrandType;
use App\GraphQL\Types\PriceType;

use App\GraphQL\Resolvers\CategoryResolver;
use App\GraphQL\Resolvers\GalleryResolver;
use App\GraphQL\Resolvers\BrandResolver;
use App\GraphQL\Resolvers\PriceResolver;

class ProductType extends ObjectType
{
    public function __construct(private Container $container)
    {
        parent::__construct([
            "name" => "Product",
            "fields" => fn(): array => [
                "id" => [
                    "type" => Type::nonNull(Type::id()),
                    "resolve" => fn(ProductInterface $product): string => $product->getId(),
                ],
                "name" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(ProductInterface $product) => $product->getName(),
                ],
                "inStock" => [
                    "type" => Type::nonNull(Type::boolean()),
                    "resolve" => fn(ProductInterface $product) => $product->isInStock()
                ],
                "description" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(ProductInterface $product) => $product->getDescription(),
                ],
                "gallery" => [
                    "type" => Type::listOf($container->get(GalleryType::class)),
                    "resolve" => [$container->get(GalleryResolver::class), "getGalleryByProductIds"]
                ],
                "category" => [
                    "type" => $container->get(CategoryType::class),
                    "resolve" => [$container->get(CategoryResolver::class), "loadProductCategory"],
                ],
                "brand" => [
                    "type" => $container->get(BrandType::class),
                    "resolve" => [$container->get(BrandResolver::class), "loadProductBrand"]
                ],
                "attributes" => [
                    "type" => Type::string(),
                    "resolve" => fn() => "To be implemented!!! by dataloaders"
                ],
                "prices" => [
                    "type" => Type::listOf($container->get(PriceType::class)),
                    "resolve" => [$container->get(PriceResolver::class), "loadPriceByProductIds"]
                ]
            ]
        ]);
    }
}
