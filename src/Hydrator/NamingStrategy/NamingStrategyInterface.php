<?php

namespace MapperBundle\Hydrator\NamingStrategy;

/**
 * Interface NamingStrategyInterface
 */
interface NamingStrategyInterface
{
    /**
     * Converts the given name so that it can be extracted by the hydrator.
     *
     * @param string $name   The original name
     * @param object $object (optional) The original object for context.
     *
     * @return string         The hydrated name
     */
    public function hydrate(string $name): string;

    /**
     * Converts the given name so that it can be hydrated by the hydrator.
     *
     * @param string $name The original name
     * @param array  $data (optional) The original data for context.
     *
     * @return string The extracted name
     */
    public function extract(string $name): string;
}
