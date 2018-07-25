<?php

namespace DataMapper\MappingRegistry;

use DataMapper\Util\RegistryContainer;

/**
 * Class DestinationRegistry
 */
final class DestinationRegistry extends RegistryContainer implements DestinationRegistryInterface
{
    /**
     * {@inheritDoc}
     */
    public function registerDestinationClass(string $className): void
    {
        $this->offsetSet($className, $className);
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredDestination(string $className): bool
    {
        return $this->offsetExists($className);
    }

    /**
     * @param string $className
     */
    public function registerSourceClass(string $className): void
    {
        $this->offsetSet($className, $className);
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasRegisteredSource(string $className): bool
    {
        return $this->offsetExists($className);
    }
}
