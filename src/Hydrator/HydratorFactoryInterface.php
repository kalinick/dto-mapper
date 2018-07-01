<?php

namespace DataMapper\Hydrator;

/**
 * Interface HydratorFactoryInterface
 */
interface HydratorFactoryInterface
{
    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return HydratorInterface
     */
    public function createHydrator($source, $destination): HydratorInterface;

    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return HydratorBuilderInterface
     */
    public function createHydratorBuilder($source, $destination): HydratorBuilderInterface;
}
