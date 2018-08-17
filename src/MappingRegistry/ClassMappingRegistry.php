<?php

namespace DataMapper\MappingRegistry;

use DataMapper\Util\RegistryContainer;

/**
 * Class ClassMappingRegistry
 */
final class ClassMappingRegistry extends RegistryContainer implements ClassMappingRegistryInterface
{
    /**
     * {@inheritDoc}
     */
    public function registerMappingClass(string $className): void
    {
        $this->offsetSet($className, $className);
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredMappingClass(string $className): bool
    {
        return $this->offsetExists($className);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllRegisteredClasses(): array
    {
        return $this->container;
    }
}
