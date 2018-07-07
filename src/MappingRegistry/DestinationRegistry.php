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
}
