<?php

declare(strict_types=1);

namespace App\Core\Container;

use ReflectionClass;
use ReflectionParameter;
use ReflectionUnionType;
use ReflectionNamedType;

use Psr\Container\ContainerInterface;

use App\Core\Container\Exceptions\ContainerException;

final class Container implements ContainerInterface
{
    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return is_callable($entry) ? $entry($this) : $entry;
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable|string $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    private function resolve(string $id)
    {
        if ($id === self::class) {
            return $this;
        }

        // 1. Inspect the class
        $reflectionClass = new ReflectionClass(objectOrClass: $id);

        if (! $reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$id} is not instantiable");
        }

        // 2. Inspect the constructor and its parameters
        $constructor = $reflectionClass->getConstructor();
        $parameters = $constructor->getParameters();

        if (! $constructor || ! $parameters) {
            $objectInstance = new $id;
            $this->set($id,  $objectInstance);
            return $objectInstance;
        }

        // 3. Construct class dependencies
        $dependencies = $this->classDependencies($parameters, $id);
        $objectInstance = $reflectionClass->newInstanceArgs($dependencies);

        $this->set($id, $objectInstance);

        return $objectInstance;
    }

    private function classDependencies(array $parameters, string $id): array
    {
        return array_map(function (ReflectionParameter $param) use ($id) {
            $name = $param->getName();
            $type = $param->getType();

            if (! $type) {
                throw new ContainerException("Failed to resolve {$id} because param {$name} is missing a type hint");
            }

            if ($type instanceof ReflectionUnionType) {
                throw new ContainerException("Failed to resolve class {$id} because of union type for param {$name}");
            }

            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                return $this->get($type->getName());
            }

            throw new ContainerException("Failed to resolve class {$id} because invalid param {$name}");
        }, $parameters);
    }
}
