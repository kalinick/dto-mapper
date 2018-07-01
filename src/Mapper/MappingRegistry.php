<?php

namespace DataMapper\Mapper;

use DataMapper\Mapper\Registry\{
    DestinationRegistry,
    DestinationRegistryInterface,
    NamingStrategyRegistry,
    NamingStrategyRegistryInterface,
    RelationsRegistry,
    RelationsRegistryInterface,
    StrategyRegistry,
    StrategyRegistryInterface
};

/**
 * Class MappingRegistry
 */
class MappingRegistry
{
    /**
     * @var NamingStrategyRegistryInterface
     */
    private $namingRegistry;

    /**
     * @var RelationsRegistryInterface
     */
    private $relationsRegistry;

    /**
     * @var StrategyRegistryInterface
     */
    private $strategyRegistry;

    /**
     * @var DestinationRegistryInterface
     */
    private $destinationRegistry;

    /**
     * MappingRegistry constructor.
     */
    public function __construct()
    {
        $this->destinationRegistry = new DestinationRegistry();
        $this->relationsRegistry = new RelationsRegistry();
        $this->namingRegistry = new NamingStrategyRegistry();
        $this->strategyRegistry = new StrategyRegistry();
    }

    /**
     * @return DestinationRegistryInterface
     */
    public function getDestinationRegistry(): DestinationRegistryInterface
    {
        return $this->destinationRegistry;
    }

    /**
     * @return RelationsRegistryInterface
     */
    public function getRelationsRegistry(): RelationsRegistryInterface
    {
        return $this->relationsRegistry;
    }

    /**
     * @return NamingStrategyRegistryInterface
     */
    public function getNamingRegistry(): NamingStrategyRegistryInterface
    {
        return $this->namingRegistry;
    }

    /**
     * @return StrategyRegistryInterface
     */
    public function getStrategyRegistry(): StrategyRegistryInterface
    {
        return $this->strategyRegistry;
    }
}
