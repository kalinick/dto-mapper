<?php

namespace DataMapper\Hydrator;

use DataMapper\Exception\InvalidArgumentException;

/**
 * Class CollectionHydrator
 */
final class CollectionHydrator extends AbstractHydrator
{
    /**
     * {@inheritDoc}
     */
    public function hydrate($source, $destination)
    {
        $this->validateTypes($source, $destination);

        $dto = \is_object($destination) ? $destination : new $destination();
        $destinationClass = \get_class($dto);

        foreach ($source as $name => $value) {
            $hydratedName = $this->hydrateName($name, $destination);
            $source[$hydratedName] = $this->hydrateValue($hydratedName, $value, [$destinationClass, $hydratedName]);
        }

        return $this->hydrateToObject($source, $dto);
    }

    /**
     * {@inheritDoc}
     */
    protected function validateTypes($source, $destination): void
    {
        $notValid = !\is_array($source) ||
            (\is_string($destination) && !\class_exists($destination)) ||
            (\is_object($destination) && !\get_class($destination));

        if ($notValid) {
            $message =  static::class . ': $source argument - must be array type,' .
                '$destination argument - must by exist class name or object type';

            throw new InvalidArgumentException($message);
        }
    }
}
