<?php

namespace MapperBundle\Hydrator;

use GeneratedHydrator\Configuration;
use MapperBundle\Hydrator\Strategy\PropertyCollectionRelatingStrategy;

/**
 * Class ArraySerializableHydrator
 */
class ArraySerializableHydrator extends AbstractHydrator
{
    /**
     * @param array         $source
     * @param object|string $destination
     *
     * @return object
     */
    public function hydrate(array $source, $destination): object
    {
        $dto = is_object($destination) ? $destination : new $destination();
        $destinationClass = get_class($dto);

        foreach ($source as $propertyName => $value) {
            $hydratedName = $propertyName;

            if ($this->hasNamingStrategy()) {
                $hydratedName = $this->getNamingStrategy()->hydrate($propertyName);
                unset($source[$propertyName]);
            }

            $value = $this->hydrateValue(PropertyCollectionRelatingStrategy::class, $hydratedName, $destinationClass, $value);
            $source[$hydratedName] = $value;
        }

        $config = new Configuration($destination);
        $hydratorClass = $config->createFactory()->getHydratorClass();

        /* @var HydratorInterface $hydrator */
        $hydrator = new $hydratorClass();
        $hydrator->hydrate($source, $dto);

        return $dto;
    }

    /**
     * @param object $type
     *
     * @return array
     */
    public function extract(object $type): array
    {
        $className = get_class($type);
        $config = new Configuration($className);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $hydrator = new $hydratorClass();
        $extracted = $hydrator->extract($type);

        if (!$this->hasNamingStrategy()) {
            return $extracted;
        }

        foreach ($extracted as $propertyName => $value) {
            $hydratedName = $this->getNamingStrategy()->extract($propertyName);
            unset($extracted[$propertyName]);
            $extracted[$hydratedName] = $value;
        }

        return $extracted;
    }
}
