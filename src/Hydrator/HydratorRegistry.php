<?php

namespace DataMapper\Hydrator;

use DataMapper\Exception\DuplicateTypeException;
use DataMapper\Hydrator\Exception\UnknownHydratorTypeException;
use DataMapper\RegistryContainer;

/**
 * Class HydratorRegistry
 */
class HydratorRegistry extends RegistryContainer implements HydratorRegistryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getHydratorByType(string $type): AbstractHydrator
    {
        if (!$this->hasRegisterHydrator($type)) {
            throw new UnknownHydratorTypeException($type);
        }

        return $this->offsetGet($type);
    }

    /**
     * {@inheritDoc}
     */
    public function registerHydrator(AbstractHydrator $hydrator, string $type): HydratorRegistryInterface
    {
        if ($this->hasRegisterHydrator($type)) {
            throw new DuplicateTypeException($type);
        }
        $this->offsetSet($type, $hydrator);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisterHydrator(string $type): bool
    {
        return $this->offsetExists($type);
    }
}
