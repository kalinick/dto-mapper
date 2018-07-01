<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\TypeDict;
use DataMapper\Hydrator\Strategy\StrategyInterface;
use DataMapper\Exception\MappingRegistryException;
use DataMapper\RegistryContainer;

/**
 * Class StrategyRegistry
 */
class StrategyRegistry extends RegistryContainer implements StrategyRegistryInterface
{
    /**
     * {@inheritDoc}
     */
    public function hasRegisteredTypeStrategy(string $key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredPropertyStrategy(string $key, string $property): bool
    {
        return $this->hasRegisteredTypeStrategy($key) ?
            isset($this->offsetGet($key)[$property]) : false;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisteredStrategiesFor(string $key): array
    {
        return $this->offsetExists($key) ? $this->offsetGet($key) : [];
    }

    /**
     * @throws MappingRegistryException
     *
     * {@inheritDoc}
     */
    public function registerPropertyStrategy(string $key, string $property, StrategyInterface $strategy): void
    {
        if ($this->hasRegisteredPropertyStrategy($key, $property)) {
            throw new MappingRegistryException("Property strategy already registered for: $key");
        }

        $value = [];
        if ($this->offsetExists($key)) {
            $value = $this->offsetGet($key);
        }

        $value[$property] = $strategy;
        $this->offsetSet($key, $value);
    }

    /**
     * @throws MappingRegistryException
     *
     * {@inheritDoc}
     */
    public function registerTypeStrategy(string $key, StrategyInterface $strategy): void
    {
        $this->registerPropertyStrategy($key, TypeDict::ALL_TYPE, $strategy);
    }

    /**
     * {@inheritDoc}
     */
    public function getMapperPropertiesKeys(string $key): array
    {
        return $this->offsetExists($key) ? \array_keys($this->offsetGet($key)) : [];
    }
}
