<?php

namespace DataMapper\Hydrator\NamingStrategy;

/**
 * Interface NamingStrategyEnabledInterface
 */
interface NamingStrategyEnabledInterface
{
    /**
     * Adds the given naming strategy
     *
     * @param NamingStrategyInterface $strategy The naming to register.
     */
    public function setNamingStrategy(NamingStrategyInterface $strategy): void;

    /**
     * Gets the naming strategy.
     *
     * @return NamingStrategyInterface|null
     */
    public function getNamingStrategy(): ?NamingStrategyInterface;

    /**
     * Checks if a naming strategy exists.
     *
     * @return bool
     */
    public function hasNamingStrategy(): bool;

    /**
     * Removes the naming with the given name.
     */
    public function removeNamingStrategy(): void;
}
