<?php

namespace MapperBundle\Hydrator;

/**
 * Interface HydrationInterface
 */
interface HydrationInterface
{
    /**
     * @param array         $values
     * @param object|string $destination
     *
     * @return object
     */
    public function hydrate(array $values, $destination): object;
}
