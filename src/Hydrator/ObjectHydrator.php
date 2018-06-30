<?php

namespace MapperBundle\Hydrator;

use GeneratedHydrator\Configuration;
use MapperBundle\Hydrator\Exception\InvalidArgumentException;

/**
 * Class ObjectHydrator
 */
class ObjectHydrator extends AbstractHydrator
{
    /**
     * {@inheritDoc}
     */
    public function hydrate($source, $destination)
    {
        if (!\is_object($source) ||
            (!\is_object($destination) || \class_exists($destination))
        ) {
            throw new InvalidArgumentException('
                $source argument - must be object type,
                $destination argument - must by exist class name or object type
            ');
        }

        $dto = \is_object($destination) ? $destination : new $destination();
        $destinationClass = \get_class($dto);

        foreach ($source as $name => $value) {
            $hydratedName = $this->hydrateName($name, $destination);
            $source[$hydratedName] = $this->hydrateValue($hydratedName, $value, $destinationClass);
        }

        $config = new Configuration($destinationClass);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        /* @var HydratorInterface $hydrator */
        $hydrator = new $hydratorClass();
        $hydrator->hydrate($source, $dto);

        return $dto;
    }
}
