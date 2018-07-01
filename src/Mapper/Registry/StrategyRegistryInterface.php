<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\Hydrator\Strategy\StrategyInterface;
use DataMapper\Mapping\Exception\MappingRegistryException;

/**
 * Interface StrategyRegistryInterface
 */
interface StrategyRegistryInterface extends DestinationRegistryInterface
{
    /**
     * @param string $source
     * @param string $destination
     *
     * @return bool
     */
    public function hasRegisteredTypeStrategy(string $source, string $destination): bool;

    /**
     * @param string $source
     * @param string $destination
     * @param string $property
     *
     * @return bool
     */
    public function hasRegisteredPropertyStrategy(string $source, string $destination, string $property): bool;

    /**
     * @param string $source
     * @param string $destination
     *
     * @return array ['name' => StrategyInterface .. etc]
     */
    public function getRegisteredStrategiesFor(string $source, string $destination): array;

    /**
     * @throws MappingRegistryException
     *
     * @param string            $source
     * @param string            $destination
     * @param string            $property
     * @param StrategyInterface $strategy
     *
     * @return void
     */
    public function registerPropertyStrategy(
        string $source,
        string $destination,
        string $property,
        StrategyInterface $strategy
    ): void;

    /**
     * @throws MappingRegistryException
     *
     * @param string            $source
     * @param string            $destination
     * @param StrategyInterface $strategy
     *
     * @return void
     */
    public function registerTypeStrategy(string $source, string $destination, StrategyInterface $strategy): void;

    /**
     * @param string $source
     * @param string $destination
     *
     * @return array
     */
    public function getMapperPropertiesKeys(string $source, string $destination): array;
}
