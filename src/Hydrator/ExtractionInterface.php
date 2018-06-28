<?php

namespace MapperBundle\Hydrator;

/**
 * Interface ExtractionInterface
 */
interface ExtractionInterface
{
    /**
     * @param mixed $type
     *
     * @return array
     */
    public function extract(object $type): array;
}
