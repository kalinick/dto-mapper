<?php

namespace DataMapper\MappingRegistry;

/**
 * Class MappingRegistryInterface
 */
interface MappingRegistryInterface
{
    /**
     * @return ClassMappingRegistryInterface
     */
    public function getClassMappingRegistry(): ClassMappingRegistryInterface;

    /**
     * @return NamingStrategyRegistryInterface
     */
    public function getNamingRegistry(): NamingStrategyRegistryInterface;

    /**
     * @return StrategyRegistryInterface
     */
    public function getStrategyRegistry(): StrategyRegistryInterface;
}
