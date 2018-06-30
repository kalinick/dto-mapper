<?php

namespace MapperBundle\Hydrator;

use MapperBundle\Hydrator\Exception\InvalidArgumentException;

/**
 * Class ArraySerializableHydrator
 */
class ArraySerializableHydrator extends AbstractHydrator
{
    /**
     * {@inheritDoc}
     */
    public function hydrate($source, $destination)
    {
        if (!\is_array($source) || !\is_array($destination)) {
            throw new InvalidArgumentException('$source and $destination arguments must be type array');
        }

        foreach ($source as $name => $value) {
            $hydratedName = $this->hydrateName($name);
            $destination[$hydratedName] = $this->hydrateValue($hydratedName, $value, $destination);
        }
    }
}
