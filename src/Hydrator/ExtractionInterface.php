<?php

namespace MapperBundle\Hydrator;

/**
 * Interface ExtractionInterface
 */
interface ExtractionInterface
{
    /**
     * @param object $type
     *
     * @return array
     */
    public function extract(object $type): array;
}
