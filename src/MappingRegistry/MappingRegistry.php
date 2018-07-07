<?php

namespace DataMapper\MappingRegistry;

/**
 * Class MappingRegistry
 */
class MappingRegistry implements MappingRegistryInterface
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
     *
     * @param DestinationRegistryInterface    $destinationRegistry
     * @param RelationsRegistryInterface      $relationsRegistry
     * @param NamingStrategyRegistryInterface $namingStrategyRegistry
     * @param StrategyRegistryInterface       $strategyRegistry
     */
    public function __construct(
        DestinationRegistryInterface $destinationRegistry,
        RelationsRegistryInterface $relationsRegistry,
        NamingStrategyRegistryInterface $namingStrategyRegistry,
        StrategyRegistryInterface $strategyRegistry
    ) {
        $this->destinationRegistry = $destinationRegistry;
        $this->relationsRegistry = $relationsRegistry;
        $this->namingRegistry = $namingStrategyRegistry;
        $this->strategyRegistry = $strategyRegistry;
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
