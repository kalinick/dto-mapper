<?php

namespace DataMapper\Hydrator;

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
    public function extract($type): array;
}
