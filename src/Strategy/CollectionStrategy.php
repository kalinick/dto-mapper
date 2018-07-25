<?php

namespace DataMapper\Strategy;

use DataMapper\Exception\InvalidArgumentException;
use DataMapper\MapperInterface;

/**
 * Class MultiCollectionStrategy
 */
class CollectionStrategy implements StrategyInterface
{
    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * @var string
     */
    private $relationTargetClass;

    /**
     * @var bool
     */
    private $isCollection;

    /**
     * CollectionStrategy constructor.
     *
     * @throws InvalidArgumentException
     *
     * @param MapperInterface $mapper
     * @param string          $relationTargetClass
     * @param bool            $isCollection
     */
    public function __construct(MapperInterface $mapper, string $relationTargetClass, bool $isCollection)
    {
        if (!\class_exists($relationTargetClass)) {
            throw new InvalidArgumentException($relationTargetClass . ' - class is not exist.');
        }

        $this->mapper = $mapper;
        $this->relationTargetClass = $relationTargetClass;
        $this->isCollection = $isCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($value, $context)
    {
        if (false === $this->isCollection) {
            return $this->mapper->convert($value, $this->relationTargetClass);
        }

        return \array_map(
            function ($element) {
                return $this->mapper->convert($element, $this->relationTargetClass);
            },
            $value
        );
    }
}
