<?php declare(strict_types=1);

namespace MapperBundle\Hydrator\Strategy;

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
