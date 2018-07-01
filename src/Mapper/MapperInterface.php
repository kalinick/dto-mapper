<?php

namespace DataMapper\Mapper;

/**
 * Interface MapperInterface
 */
interface MapperInterface
{
    /**
     * @param array|object        $source
     * @param object|string|array $destination
     *
     * @return object|array
     */
    public function convert($source, $destination);

    /**
     * @param object $source
     *
     * @return array
     */
    public function extract(object $source): array;
}
