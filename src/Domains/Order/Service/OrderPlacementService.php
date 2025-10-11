<?php

declare(strict_types=1);

namespace App\Domains\Order\Service;

use App\Exceptions\AppException;
use Exception;
use PDO;

use App\Domains\OrderItemAttribute\Repository\OrderItemAttributeRepository;
use App\Domains\OrderItem\Repository\OrderItemRepository;
use App\Domains\Order\Repository\OrderRepository;
use App\Exceptions\DatabaseException;

class OrderPlacementService
{
    public function __construct(
        private PDO $connection,
        private OrderRepository $orderRepository,
        private OrderItemRepository $orderItemRepository,
        private OrderItemAttributeRepository $orderItemAttributeRepository
    ) {}


    public function placeOrder(array $items): int
    {
        $orderCurrencyId = $items[0]['currencyId'];
        $totalAmount = $this->calculateTotalPrice($items);

        try {
            $this->connection->beginTransaction();

            $orderId = $this->orderRepository->createOrder($totalAmount, $orderCurrencyId);

            foreach ($items as $item) {
                $orderItemId = $this->orderItemRepository->createOrderItem(
                    $orderId,
                    $item['productId'],
                    $item["quantity"],
                    $item['unitPrice'],
                    $item['currencyId']
                );

                $itemAttributes = $item['attributes'];

                foreach ($itemAttributes as $attr) {
                    $this->orderItemAttributeRepository->createOrderItemAttribute(
                        $orderItemId,
                        $attr['attributeId'],
                        $attr['attributeSetId']
                    );
                }
            }

            $this->connection->commit();

            return $orderId;
        } catch (DatabaseException $e) {
            $this->connection->rollBack();
            throw $e;
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw new AppException();
        }
    }

    private function calculateTotalPrice(array $items): float
    {
        $total = 0.00;

        foreach ($items as $item) {
            $total += $item['unitPrice'] * $item["quantity"];
        }

        return $total;
    }
}
