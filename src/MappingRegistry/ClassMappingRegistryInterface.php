<?php

namespace DataMapper\MappingRegistry;

/**
 * Interface ClassMappingRegistryInterface
 */
interface ClassMappingRegistryInterface
{
    /**
     * @param string $className
     */
    public function registerMappingClass(string $className): void;

    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasRegisteredMappingClass(string $className): bool;

    /**
     * @return array
     */
    public function getAllRegisteredClasses(): array;
}
