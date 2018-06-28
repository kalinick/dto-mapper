<?php

namespace MapperBundle\Hydrator\NamingStrategy;

/**
 * Interface NamingStrategyEnabledInterface
 */
interface NamingStrategyEnabledInterface
{
    /**
     * Adds the given naming strategy
     *
     * @param NamingStrategyInterface $strategy The naming to register.
     *
     * @return self
     */
    public function setNamingStrategy(NamingStrategyInterface $strategy): NamingStrategyEnabledInterface;

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
     *
     * @return self
     */
    public function removeNamingStrategy(): NamingStrategyEnabledInterface;
}
