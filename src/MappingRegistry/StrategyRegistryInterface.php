<?php

namespace DataMapper\MappingRegistry;

use DataMapper\MappingRegistry\Exception\MappingRegistryException;

/**
 * Interface StrategyRegistryInterface
 */
interface StrategyRegistryInterface
{
    /**
     * @param string $key
     * @param string $property
     *
     * @return bool
     */
    public function hasRegisteredPropertyStrategy(string $key, string $property): bool;

    /**
     * @param string $key
     *
     * @return array ['name' => StrategyInterface .. etc]
     */
    public function loadRegisteredStrategiesFor(string $key): array;

    /**
     * @throws MappingRegistryException
     *
     * @param string            $key
     * @param string            $property
     * @param string            $strategyClass
     * @param array             $strategyArgs
     *
     * @return void
     */
    public function registerPropertyStrategy(
        string $key,
        string $property,
        string $strategyClass,
        array $strategyArgs = []
    ): void;
}
