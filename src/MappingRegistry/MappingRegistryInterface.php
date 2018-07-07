<?php

namespace DataMapper\MappingRegistry;

/**
 * Class MappingRegistryInterface
 */
interface MappingRegistryInterface
{
    /**
     * @return DestinationRegistryInterface
     */
    public function getDestinationRegistry(): DestinationRegistryInterface;

    /**
     * @return RelationsRegistryInterface
     */
    public function getRelationsRegistry(): RelationsRegistryInterface;

    /**
     * @return NamingStrategyRegistryInterface
     */
    public function getNamingRegistry(): NamingStrategyRegistryInterface;

    /**
     * @return StrategyRegistryInterface
     */
    public function getStrategyRegistry(): StrategyRegistryInterface;
}
