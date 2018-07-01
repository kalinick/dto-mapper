<?php

namespace DataMapper\Hydrator\NamingStrategy;

/**
 * Class IdentityNamingStrategy
 */
final class IdentityNamingStrategy implements NamingStrategyInterface
{
    /**
     * {@inheritDoc}
     */
    public function hydrate(string $name, $context = null): string
    {
        return $name;
    }

    /**
     * {@inheritDoc}
     */
    public function extract(string $name): string
    {
        return $name;
    }
}
