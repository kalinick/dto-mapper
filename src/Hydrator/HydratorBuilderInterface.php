<?php

namespace MapperBundle\Hydrator;

use MapperBundle\Hydrator\NamingStrategy\NamingStrategyInterface;
use MapperBundle\Hydrator\Strategy\StrategyInterface;

/**
 * Interface HydratorBuilderInterface
 */
interface HydratorBuilderInterface
{
    /**
     * @param NamingStrategyInterface|null $namingStrategy
     *
     * @return HydratorBuilderInterface
     */
    public function setNamingStrategy(NamingStrategyInterface $namingStrategy): HydratorBuilderInterface;

    /**
     * @param string            $name
     * @param StrategyInterface $strategy
     *
     * @return HydratorBuilderInterface
     */
    public function addStrategy(string $name, StrategyInterface $strategy): HydratorBuilderInterface;

    /**
     * @return HydratorBuilderInterface
     */
    public function removeNamingStrategy(): HydratorBuilderInterface;

    /**
     * @param string $name
     *
     * @return HydratorBuilderInterface
     */
    public function removeStrategy(string $name): HydratorBuilderInterface;

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
