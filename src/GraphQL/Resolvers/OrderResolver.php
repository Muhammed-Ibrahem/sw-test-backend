<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Domains\OrderItemAttribute\DTO\OrderItemAttributeDTO;
use App\Domains\Order\Service\OrderPlacementService;
use App\Domains\OrderItem\DTO\OrderItemDTO;
use App\Domains\Order\DTO\OrderDTO;

class OrderResolver
{
    public function __construct(
        private OrderPlacementService $orderPlacementService
    ) {}
    public function placeOrder($root, array $args)
    {
        /** @var array */
        $rawItems = $args['orderItems'];

        $orderDTO = $this->constructOrder($rawItems);

        return $this->orderPlacementService->placeOrder($orderDTO);
    }


    private function constructOrder(array $rawItems): OrderDTO
    {
        $orderItems = array_map(function (array $itemData): OrderItemDTO {

            /** @var array */
            $attrs = $itemData['attributes'] ?? [];

            $attributes = array_map(fn(array $attrData): OrderItemAttributeDTO =>
            new OrderItemAttributeDTO(
                $attrData['attributeSetId'],
                $attrData['attributeId']
            ), $attrs);


            return new OrderItemDTO(
                $itemData['productId'],
                $itemData['quantity'],
                $itemData['unitPrice'],
                $itemData['currencyId'],
                $attributes
            );
        }, $rawItems);

        return new OrderDTO($orderItems);
    }
}
