<?php

namespace DataMapper\Mapper;

use DataMapper\Hydrator\HydratorFactoryInterface;

/**
 * Class Mapper
 */
class Mapper implements MapperInterface
{
    /**
     * @var HydratorFactoryInterface
     */
    private $hydratorFactory;

    /**
     * Mapper constructor.
     *
     * @param HydratorFactoryInterface $hydratorFactory
     */
    public function __construct(HydratorFactoryInterface $hydratorFactory)
    {
        $this->hydratorFactory = $hydratorFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function convert($source, $destination)
    {
        return $this
            ->hydratorFactory
            ->createHydrator($source, $destination)
            ->hydrate($source, $destination);
    }

    /**
     * {@inheritDoc}
     */
    public function extract(object $source): array
    {
        return $this
            ->hydratorFactory
            ->createHydrator($source, [])
            ->extract($source);
    }
}
