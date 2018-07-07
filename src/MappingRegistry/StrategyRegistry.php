<?php

namespace DataMapper\MappingRegistry;

use DataMapper\MappingRegistry\Exception\MappingRegistryException;
use DataMapper\Strategy\StrategyInterface;
use DataMapper\Util\RegistryContainer;

/**
 * Class StrategyRegistry
 */
final class StrategyRegistry extends RegistryContainer implements StrategyRegistryInterface
{
    /**
     * {@inheritDoc}
     */
    public function hasRegisteredPropertyStrategy(string $key, string $property): bool
    {
        return $this->offsetExists($key) ? isset($this->offsetGet($key)[$property]) : false;
    }

    /**
     * {@inheritDoc}
     */
    public function loadRegisteredStrategiesFor(string $key): array
    {
        if (!$this->offsetExists($key)) {
            return [];
        }

        return array_map(
            function ($mapping) {
                [$class, $args] = $mapping;
                return new $class(...$args);
            },
            $this->offsetGet($key)
        );
    }

    /**
     * @throws MappingRegistryException
     *
     * {@inheritDoc}
     */
    public function registerPropertyStrategy(
        string $key,
        string $property,
        string $strategyClass,
        array $strategyArgs = []
    ): void {

        if ($this->hasRegisteredPropertyStrategy($key, $property)) {
            throw new MappingRegistryException("Property strategy already registered for: $key");
        }

        if (!class_exists($strategyClass)) {
            throw new MappingRegistryException("Could not find class: $strategyClass");
        }

        if (!\array_key_exists(StrategyInterface::class, class_implements($strategyClass))) {
            throw new MappingRegistryException("Class: $strategyClass must implement - " . StrategyInterface::class);
        }

        $value = [];
        if ($this->offsetExists($key)) {
            $value = $this->offsetGet($key);
        }

        $value[$property] = [$strategyClass, $strategyArgs];
        $this->offsetSet($key, $value);
    }
}
