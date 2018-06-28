<?php

namespace MapperBundle\Mapper;

use MapperBundle\Hydrator\HydratorFactory;
use MapperBundle\Mapper\Exception\InvalidTypeException;
use MapperBundle\Hydrator\NamingStrategy\NamingStrategyInterface;

/**
 * Class Mapper
 */
class Mapper implements MapperInterface
{
    /**
     * @var HydratorFactory
     */
    private $hydratorFactory;

    /**
     * Mapper constructor.
     *
     * @param HydratorFactory $hydratorFactory
     */
    public function __construct(HydratorFactory $hydratorFactory)
    {
        $this->hydratorFactory = $hydratorFactory;
    }

    /**
     * @param array|object  $source
     * @param object|string $destination
     *
     * @return mixed
     */
    public function convert($source, $destination)
    {
        return $this
            ->hydratorFactory
            ->createHydrator($source, $destination)
            ->hydrate($source, $destination);
    }

    /**
     * @param object $source
     *
     * @return array
     */
    public function extract(object $source): array
    {
        return $this
            ->hydratorFactory
            ->createHydrator($source, [])
            ->extract($source);
    }
}
