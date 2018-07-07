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
     * @param string $key
     *
     * @return NamingStrategyInterface|null
     */
    public function getRegisteredNamingStrategyFor(string $key): ?NamingStrategyInterface;

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasRegisteredNamingStrategyFor(string $key): bool;

    /**
     * @throws MappingRegistryException
     *
     * @param string                  $key
     * @param NamingStrategyInterface $strategy
     */
    public function registerNamingStrategy(string $key, NamingStrategyInterface $strategy): void;
}
