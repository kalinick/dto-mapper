<?php

namespace DataMapper\Hydrator;

use DataMapper\Exception\InvalidArgumentException;

/**
 * Class ArrayCollectionHydrator
 */
class ArrayCollectionHydrator extends AbstractHydrator
{
    /**
     * {@inheritDoc}
     */
    public function hydrate($source, $destination)
    {
        $this->validateTypes($source, $destination);
        $dto = new $destination();

        foreach ($source as $sourceKey => $sourceValue) {
            $hydratedName = $this->hydrateName($sourceKey, $destination);

            if ($hydratedName !== $sourceKey) {
                unset($source[$sourceKey]);
            }

            $source[$hydratedName] = $this->hydrateValue($hydratedName, $sourceValue, $destination);
        }

        return $this->hydrateToObject($source, $dto);
    }

    /**
     * {@inheritDoc}
     */
    protected function validateTypes($source, $destination): void
    {
        if (!\is_array($source)) {
            throw new InvalidArgumentException('$source argument - must be array type');
        }

        if (\is_string($destination) && !\class_exists($destination)) {
            throw new InvalidArgumentException('$destination argument - must by exist class name or object type');
        }
    }
}
