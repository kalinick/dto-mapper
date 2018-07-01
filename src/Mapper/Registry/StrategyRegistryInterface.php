<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\Hydrator\Strategy\StrategyInterface;
use DataMapper\Exception\MappingRegistryException;

/**
 * Interface StrategyRegistryInterface
 */
interface StrategyRegistryInterface
{
    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasRegisteredTypeStrategy(string $key): bool;

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
    public function getRegisteredStrategiesFor(string $key): array;

    /**
     * @throws MappingRegistryException
     *
     * @param string            $key
     * @param string            $property
     * @param StrategyInterface $strategy
     *
     * @return void
     */
    public function registerPropertyStrategy(string $key, string $property, StrategyInterface $strategy): void;

    /**
     * @throws MappingRegistryException
     *
     * @param string            $key
     * @param StrategyInterface $strategy
     *
     * @return void
     */
    public function registerTypeStrategy(string $key, StrategyInterface $strategy): void;

    /**
     * @param string $key
     *
     * @return array
     */
    public function getMapperPropertiesKeys(string $key): array;
}
