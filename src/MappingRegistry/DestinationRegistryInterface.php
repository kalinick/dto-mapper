<?php

namespace DataMapper\MappingRegistry;

/**
 * Interface DestinationRegistryInterface
 */
interface DestinationRegistryInterface
{
    /**
     * @param string $className
     */
    public function registerDestinationClass(string $className): void;

    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasRegisteredDestination(string $className): bool;
}
