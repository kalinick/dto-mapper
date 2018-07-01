<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\Hydrator\NamingStrategy\NamingStrategyInterface;
use DataMapper\Mapping\Exception\MappingRegistryException;

/**
 * Trait NamingStrategyRegistryTrait
 */
trait NamingStrategyRegistryTrait
{
    /**
     * @var array
     */
    protected $registeredNamingStrategies = [];

    /**
     * {@inheritDoc}
     */
    public function getRegisteredNamingStrategyFor($destination): ?NamingStrategyInterface
    {
        if (\is_object($destination)) {
            $destination = \get_class($destination);
        }

        return $this->registeredNamingStrategies[$destination] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredNamingStrategyFor(string $destination): bool
    {
        return isset($this->registeredNamingStrategies[$destination]);
    }

    /**
     * {@inheritDoc}
     */
    public function registerNamingStrategy(
        string $destination,
        NamingStrategyInterface $strategy
    ): void {
        if ($this->hasRegisteredNamingStrategyFor($destination)) {
            throw new MappingRegistryException("Naming strategy for {$destination} already registered");
        }

        $this->registeredNamingStrategies[$destination] = $strategy;
    }
}
