<?php

declare(strict_types=1);

namespace App\GraphQL\DataLoader;

abstract class Loader
{
    protected array $ids = [];

    protected array $valueGroupedById = [];

    public function load($id): void
    {
        $this->ids[$id] = $id;
    }

    public function loadBatch(callable $dataCallback): void
    {
        if (empty($this->ids)) return;

        $idsToLoad = \array_values($this->ids);

        $this->valueGroupedById = $dataCallback($idsToLoad);

        $this->ids = [];
    }

    public function getValue($id)
    {
        return $this->valueGroupedById[$id];
    }

    abstract public function loadBuffered(): void;
}
