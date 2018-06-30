<?php

namespace MapperBundle\Hydrator\Strategy;

use MapperBundle\Hydrator\Exception\UnknownStrategyTypeException;

/**
 * Interface StrategyEnabledInterface
 */
interface StrategyEnabledInterface
{
    /**
     * @param string            $name
     * @param StrategyInterface $strategy
     *
     * @return StrategyEnabledInterface
     */
    public function addStrategy(string $name, StrategyInterface $strategy): StrategyEnabledInterface;

    /**
     * @throws UnknownStrategyTypeException
     *
     * @param string $name
     *
     * @return StrategyInterface
     */
    public function getStrategy(string $name): StrategyInterface;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasStrategy(string $name): bool;

    /**
     * @param string $name
     *
     * @return StrategyEnabledInterface
     */
    public function removeStrategy(string $name): StrategyEnabledInterface;
}
