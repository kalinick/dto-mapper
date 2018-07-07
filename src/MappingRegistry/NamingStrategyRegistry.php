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
    public function getRegisteredNamingStrategyFor($destination): ?NamingStrategyInterface
    {
        $destination = TypeResolver::resolveStrategyType($destination);

        return $this->offsetExists($destination) ?
            $this->offsetGet($destination): null;
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredNamingStrategyFor(string $destination): bool
    {
        return $this->offsetGet($destination);
    }

    /**
     * {@inheritDoc}
     */
    public function registerNamingStrategy(string $destination, NamingStrategyInterface $strategy): void
    {
        $this->offsetSet($destination, $strategy);
    }
}
