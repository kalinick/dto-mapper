<?php

namespace DataMapper;

use DataMapper\Exception\DuplicateTypeException;
use DataMapper\Exception\MappingRegistryException;

/**
 * Class RegistryContainer
 */
class RegistryContainer implements \ArrayAccess
{
    /**
     * @var array
     */
    private $container = [];

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * @throws MappingRegistryException
     *
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new MappingRegistryException(static::class . ": offset - $offset not registered yet");
        }

        return $this->container[$offset];
    }

    /**
     * @throws DuplicateTypeException
     *
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->container[$offset] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }
}
