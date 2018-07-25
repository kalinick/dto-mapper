<?php

namespace DataMapper\Strategy;

use DataMapper\Exception\InvalidArgumentException;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\MappingRegistry\RelationsRegistryInterface;

/**
 * Class SerializerStrategy
 */
class SerializerStrategy implements StrategyInterface
{
    /**
     * @var RelationsRegistryInterface
     */
    private $mappingRegistry;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @var string
     */
    private $relationTargetClass;

    /**
     * @var bool
     */
    private $isCollection;

    /**
     * SerializerStrategy constructor.
     *
     * @throws InvalidArgumentException
     *
     * @param HydratorInterface $hydrator
     * @param string            $relationTargetClass
     * @param bool              $isCollection
     */
    public function __construct(HydratorInterface $hydrator, string $relationTargetClass, bool $isCollection)
    {
        if (!\class_exists($relationTargetClass)) {
            throw new InvalidArgumentException($relationTargetClass . ' - class is not exist.');
        }

        $this->hydrator = $hydrator;
        $this->relationTargetClass = $relationTargetClass;
        $this->isCollection = $isCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($value, $context)
    {
        if (!\is_array($value)) {
            return $value;
        }

        if (!$this->isCollection) {
            return $this->hydrator->hydrate($value, $this->relationTargetClass);
        }

        return \array_map(
            function ($element) {
                return $this->hydrator->hydrate($element, $this->relationTargetClass);
            },
            $value
        );
    }
}
