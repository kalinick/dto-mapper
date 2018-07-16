<?php

namespace DataMapper\MappingRegistry;

use DataMapper\MappingRegistry\Exception\MappingRegistryException;
use DataMapper\Strategy\StrategyInterface;
use DataMapper\Type\TypeDict;
use DataMapper\Type\TypeResolver;
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
        $defaultStrategies = [];
        $registeredStrategies = [];

        [$source, $destination] = \explode(TypeDict::STRATEGY_GLUE, $key);
        $defaultStrategiesKey = TypeResolver::implodeType(
            TypeDict::ALL_TYPE,
            $destination,
            TypeDict::HYDRATOR_GLUE
        );

        if ($this->offsetExists($defaultStrategiesKey)) {
            $defaultStrategies = $this->offsetGet($defaultStrategies);
        }


        if ($this->offsetExists($key)) {
            $registeredStrategies = $this->offsetGet($key);
        }

        return \array_merge($defaultStrategies, $registeredStrategies);
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
}
