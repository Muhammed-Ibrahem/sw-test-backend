<?php

declare(strict_types=1);

namespace App\Domains\OrderItemAttribute\DTO;


final class OrderItemAttributeDTO
{
    private readonly string $attributeSetId;
    private readonly string $attributeId;

    public function __construct(
        string $attributeSetId,
        string $attributeId
    ) {
        $this->setAttributeSetId($attributeSetId);
        $this->setAttributeId($attributeId);
    }

    private function setAttributeSetId(string $attrSetId)
    {
        if (empty($attrSetId)) {
            throw new \InvalidArgumentException("AttributeSetId is a required field", 400);
        }

        $this->attributeSetId = $attrSetId;
    }
    private function setAttributeId(string $attrId)
    {
        if (empty($attrId)) {
            throw new \InvalidArgumentException("AttributeId is a required field", 400);
        }

        $this->attributeId = $attrId;
    }

    public function getAttributeSetId(): string
    {
        return $this->attributeSetId;
    }
    public function getAttributeId(): string
    {
        return $this->attributeId;
    }
}
