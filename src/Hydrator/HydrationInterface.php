<?php

namespace MapperBundle\Hydrator;

use MapperBundle\Hydrator\Exception\InvalidArgumentException;

/**
 * Interface HydrationInterface
 */
interface HydrationInterface
{
    /**
     * @throws InvalidArgumentException
     *
     * @param array|object         $source
     * @param object|string|array  $destination
     *
     * @return array|object
     */
    public function hydrate($source, $destination);
}
