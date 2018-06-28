<?php

namespace MapperBundle\Hydrator;

use MapperBundle\Hydrator\NamingStrategy\NamingStrategyInterface;
use MapperBundle\Hydrator\Strategy\StrategyInterface;

/**
 * Class HydratorBuilder
 */
class HydratorBuilder
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
     * @return HydratorBuilder
     */
    public static function create(AbstractHydrator $hydrator): self
    {
        return new self($hydrator);
    }

    /**
     * @param string            $name
     * @param StrategyInterface $strategy
     *
     * @return HydratorBuilder
     */
    public function addStrategy(string $name, StrategyInterface $strategy): self
    {
        $this->hydrator->addStrategy($name, $strategy);

        return $this;
    }

    /**
     * @param NamingStrategyInterface $namingStrategy
     *
     * @return HydratorBuilder
     */
    public function setNamingStrategy(NamingStrategyInterface $namingStrategy): self
    {
        $this->hydrator->setNamingStrategy($namingStrategy);

        return $this;
    }


    /**
     * @return HydratorBuilder
     */
    public function removeNamingStrategy(): self
    {
        $this->hydrator->removeNamingStrategy();

        return $this;
    }

    /**
     * @param string $name
     *
     * @return HydratorBuilder
     */
    public function removeStrategy(string $name): self
    {
        $this->hydrator->removeStrategy($name);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasStrategy(string $name): bool
    {
        return $this->hydrator->hasStrategy($name);
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }
}
