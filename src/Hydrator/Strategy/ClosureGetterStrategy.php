<?php

namespace DataMapper\Hydrator\Strategy;

use DataMapper\Exception\InvalidArgumentException;

/**
 * Class ClosureGetterStrategy
 */
final class ClosureGetterStrategy implements StrategyInterface
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
