<?php

namespace DataMapper\MappingRegistry;

use DataMapper\Util\RegistryContainer;
use DataMapper\NamingStrategy\NamingStrategyInterface;
use DataMapper\Type\TypeResolver;

/**
 * Class DestinationRegistry
 */
final class NamingStrategyRegistry extends RegistryContainer implements NamingStrategyRegistryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getRegisteredNamingStrategyFor(string $key): ?NamingStrategyInterface
    {
        return $this->offsetExists($key) ? $this->offsetGet($key): null;
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredNamingStrategyFor(string $key): bool
    {
        return $this->offsetGet($key);
    }

    /**
     * {@inheritDoc}
     */
    public function registerNamingStrategy(string $key, NamingStrategyInterface $strategy): void
    {
        $this->offsetSet($key, $strategy);
    }
}
