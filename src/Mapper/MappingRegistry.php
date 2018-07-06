<?php

namespace DataMapper\Mapper;

use DataMapper\Mapper\Registry;

/**
 * Class MappingRegistry
 */
class MappingRegistry
{
    /**
     * @var Registry\NamingStrategyRegistryInterface
     */
    private $namingRegistry;

    /**
     * @var Registry\RelationsRegistryInterface
     */
    private $relationsRegistry;

    /**
     * @var Registry\StrategyRegistryInterface
     */
    private $strategyRegistry;

    /**
     * @var Registry\DestinationRegistryInterface
     */
    private $destinationRegistry;

    /**
     * MappingRegistry constructor.
     *
     * @param Registry\DestinationRegistryInterface    $destinationRegistry
     * @param Registry\RelationsRegistryInterface      $relationsRegistry
     * @param Registry\NamingStrategyRegistryInterface $namingStrategyRegistry
     * @param Registry\StrategyRegistryInterface       $strategyRegistry
     */
    public function __construct(
        Registry\DestinationRegistryInterface $destinationRegistry,
        Registry\RelationsRegistryInterface $relationsRegistry,
        Registry\NamingStrategyRegistryInterface $namingStrategyRegistry,
        Registry\StrategyRegistryInterface $strategyRegistry
    ) {
        $this->destinationRegistry = $destinationRegistry;
        $this->relationsRegistry = $relationsRegistry;
        $this->namingRegistry = $namingStrategyRegistry;
        $this->strategyRegistry = $strategyRegistry;
    }

    /**
     * @return Registry\DestinationRegistryInterface
     */
    public function getDestinationRegistry(): Registry\DestinationRegistryInterface
    {
        return $this->destinationRegistry;
    }

    /**
     * @return Registry\RelationsRegistryInterface
     */
    public function getRelationsRegistry(): Registry\RelationsRegistryInterface
    {
        return $this->relationsRegistry;
    }

    /**
     * @return Registry\NamingStrategyRegistryInterface
     */
    public function getNamingRegistry(): Registry\NamingStrategyRegistryInterface
    {
        return $this->namingRegistry;
    }

    /**
     * @return Registry\StrategyRegistryInterface
     */
    public function getStrategyRegistry(): Registry\StrategyRegistryInterface
    {
        return $this->strategyRegistry;
    }
}
