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
     * @param NamingStrategyRegistryInterface $namingStrategyRegistry
     * @param StrategyRegistryInterface       $strategyRegistry
     */
    public function __construct(
        DestinationRegistryInterface $destinationRegistry,
        NamingStrategyRegistryInterface $namingStrategyRegistry,
        StrategyRegistryInterface $strategyRegistry
    ) {
        $this->destinationRegistry = $destinationRegistry;
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
