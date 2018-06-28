<?php

namespace MapperBundle\Mapping;

use Doctrine\Common\Annotations\AnnotationReader;
use MapperBundle\Mapping\Annotation\DestinationMetaInterface;
use MapperBundle\Mapping\Annotation\DestinationMetaReader;
use MapperBundle\Mapping\Exception\UnregisteredDestinationException;

/**
 * Class MappingRegistry
 */
class MappingRegistry
{
    /**
     * @var array
     */
    private $registeredDestinations = [];

    /**
     * @var array
     */
    private $registeredRelationsMapping = [];

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * MappingRegistry constructor.
     *
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param string $className
     *
     * @return void
     */
    public function registerMappedDestinationClass(string $className): void
    {
        $this->registerDestination($className, DestinationMetaReader::read($this->annotationReader, $className));
    }

    /**
     * @param string                $className
     * @param DestinationMetaReader $metaReader
     *
     * @return void
     */
    public function registerDestination(string $className, DestinationMetaReader $metaReader): void
    {
        if (!isset($this->registeredDestinations[$className])) {
            $this->registeredDestinations[$className] = $metaReader;
        }

        if ($metaReader->hasPropertyRelations()) {
            $this->registeredRelationsMapping[$className] = $metaReader;
        }
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasRegisteredDestination(string $className): bool
    {
        return isset($this->registeredDestinations[$className]);
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasRegisteredRelationsMapping(string $className): bool
    {
        return isset($this->registeredRelationsMapping[$className]);
    }

    /**
     * @throws UnregisteredDestinationException
     *
     * @param string $destinationClass
     *
     * @return DestinationMetaInterface
     */
    public function loadRelationsMapping(string $destinationClass): DestinationMetaInterface
    {
        if (!$this->hasRegisteredRelationsMapping($destinationClass)) {
            throw new UnregisteredDestinationException('Class:' . $destinationClass . ' has no registered relations mapping');
        }

        return $this->registeredRelationsMapping[$destinationClass];
    }
}
