<?php

namespace DataMapper\MappingRegistry;

use DataMapper\NamingStrategy\NamingStrategyInterface;
use DataMapper\MappingRegistry\Exception\MappingRegistryException;

/**
 * Interface NamingStrategyRegistryInterface
 */
interface NamingStrategyRegistryInterface
{
    /**
     * @param mixed $destination
     *
     * @return NamingStrategyInterface|null
     */
    public function getRegisteredNamingStrategyFor($destination): ?NamingStrategyInterface;

    /**
     * @param string $destination
     *
     * @return bool
     */
    public function hasRegisteredNamingStrategyFor(string $destination): bool;

    /**
     * @throws MappingRegistryException
     *
     * @param string                  $destination
     * @param NamingStrategyInterface $strategy
     */
    public function registerNamingStrategy(string $destination, NamingStrategyInterface $strategy): void;
}
