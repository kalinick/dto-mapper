<?php

namespace DataMapper\Strategy;

use DataMapper\Exception\InvalidArgumentException;

/**
 * Class ClosureStrategy
 */
final class ClosureStrategy implements StrategyInterface
{
    /**
     * @var \Closure
     */
    private $hydrateFunc;

    /**
     * ClosureStrategy constructor.
     *
     * @param \Closure $hydrateFunc
     *
     * @throws InvalidArgumentException
     */
    public function __construct(\Closure $hydrateFunc)
    {
        if (!\is_callable($hydrateFunc)) {
            throw new InvalidArgumentException('$hydrateFunc must be callable');
        }

        $this->hydrateFunc = $hydrateFunc;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($value, $context)
    {
        $func = $this->hydrateFunc;

        return $func($value, $context);
    }
}
