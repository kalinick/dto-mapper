<?php

namespace DataMapper\Hydrator;

use DataMapper\Hydrator\Exception\InvalidArgumentException;

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
        $notValid = !\is_array($source) || (!\get_class($destination) || !\class_exists($destination));

        if ($notValid) {
            $message = '$source argument - must be array type,' .
                '$destination argument - must by exist class name or object type';

            throw new InvalidArgumentException($message);
        }
        $dto = \is_object($destination) ? $destination : new $destination();
        $destinationClass = \get_class($dto);

        foreach ($source as $name => $value) {
            $hydratedName = $this->hydrateName($name, $destination);
            $source[$hydratedName] = $this->hydrateValue($hydratedName, $value, $destinationClass);
        }

        return $this->hydrateToObject($source, $dto);
    }
}
