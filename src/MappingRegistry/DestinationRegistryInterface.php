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

    /**
     * @param string $className
     */
    public function registerSourceClass(string $className): void;

    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasRegisteredSource(string $className): bool;
}
