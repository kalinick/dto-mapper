<?php

namespace DataMapper\Hydrator;

use DataMapper\Hydrator\NamingStrategy\NamingStrategyInterface;
use DataMapper\Hydrator\Strategy\StrategyInterface;

/**
 * Class HydratorBuilder
 */
class HydratorBuilder implements HydratorBuilderInterface
{
    /**
     * @var AbstractHydrator
     */
    private $hydrator;

    /**
     * HydratorBuilder constructor.
     *
     * @param AbstractHydrator $hydrator
     */
    private function __construct(AbstractHydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @param AbstractHydrator $hydrator
     *
     * @return HydratorBuilderInterface
     */
    public static function create(AbstractHydrator $hydrator): HydratorBuilderInterface
    {
        return new self($hydrator);
    }

    /**
     * {@inheritDoc}
     */
    public function addStrategy(string $name, StrategyInterface $strategy): HydratorBuilderInterface
    {
        $this->hydrator->addStrategy($name, $strategy);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setNamingStrategy(NamingStrategyInterface $namingStrategy): HydratorBuilderInterface
    {
        $this->hydrator->setNamingStrategy($namingStrategy);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeNamingStrategy(): HydratorBuilderInterface
    {
        $this->hydrator->removeNamingStrategy();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeStrategy(string $name): HydratorBuilderInterface
    {
        $this->hydrator->removeStrategy($name);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasStrategy(string $name): bool
    {
        return $this->hydrator->hasStrategy($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }
}
