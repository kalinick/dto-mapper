<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\Mapping\Exception\MappingRegistryException;

/**
 * Trait DestinationRegistryTrait
 */
trait DestinationRegistryTrait
{
    /**
     * @var array
     */
    protected $registeredDestinations = [];

    /**
     * {@inheritDoc}
     */
    public function registerDestinationClass(string $className): void
    {
        if ($this->hasRegisteredDestination($className)) {
            throw new MappingRegistryException("Destination class {$className} already registered");
        }

        $this->registeredDestinations[] = $className;
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredDestination(string $className): bool
    {
        return \in_array($className, $this->registeredDestinations, false);
    }
}
