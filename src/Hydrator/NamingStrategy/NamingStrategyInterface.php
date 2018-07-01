<?php

namespace DataMapper\Hydrator\NamingStrategy;

/**
 * Interface NamingStrategyInterface
 */
interface NamingStrategyInterface
{
    /**
     * Converts the given name so that it can be extracted by the hydrator.
     *
     * @param string $name   The original name
     * @param mixed  $context (optional) The original object for context.
     *
     * @return string         The hydrated name
     */
    public function hydrate(string $name, $context = null): string;

    /**
     * Converts the given name so that it can be hydrated by the hydrator.
     *
     * @param string $name    The original name
     *
     * @return string The extracted name
     */
    public function extract(string $name): string;
}
