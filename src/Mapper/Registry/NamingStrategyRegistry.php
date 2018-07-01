<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\RegistryContainer;
use DataMapper\Hydrator\NamingStrategy\NamingStrategyInterface;

/**
 * Class DestinationRegistry
 */
class NamingStrategyRegistry extends RegistryContainer implements NamingStrategyRegistryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getRegisteredNamingStrategyFor($destination): ?NamingStrategyInterface
    {
        if (\is_object($destination)) {
            $destination = \get_class($destination);
        }

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
