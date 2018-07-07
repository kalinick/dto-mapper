<?php

namespace DataMapper\Hydrator;

use DataMapper\NamingStrategy\NamingStrategyInterface;
use DataMapper\Strategy\StrategyInterface;

/**
 * Interface HydratorBuilderInterface
 */
interface HydratorBuilderInterface
{
    /**
     * @param NamingStrategyInterface|null $namingStrategy
     *
     * @return void
     */
    public function setNamingStrategy(NamingStrategyInterface $namingStrategy): void;

    /**
     * @param string            $name
     * @param StrategyInterface $strategy
     *
     * @return void
     */
    public function addStrategy(string $name, StrategyInterface $strategy): void;

    /**
     * @return void
     */
    public function removeNamingStrategy(): void;

    /**
     * @param string $name
     *
     * @return void
     */
    public function removeStrategy(string $name): void;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasStrategy(string $name): bool;

    /**
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface;
}
