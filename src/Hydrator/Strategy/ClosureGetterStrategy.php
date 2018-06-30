<?php

namespace MapperBundle\Hydrator\Strategy;

use MapperBundle\Mapping\Annotation\Exception\InvalidArgumentException;

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
     * @param \Closure|null $hydrateFunc
     *
     * @throws InvalidArgumentException
     */
    public function __construct(\Closure $hydrateFunc = null)
    {
        if ($hydrateFunc !== null && !\is_callable($hydrateFunc)) {
            throw new InvalidArgumentException('$hydrateFunc must be callable');
        }

        if ($hydrateFunc === null) {
            $this->hydrateFunc = function ($value) {
                return $value;
            };
        } else {
            $this->hydrateFunc = $hydrateFunc;
        }
    }

    /**
     * @param mixed $value
     * @param mixed $context
     *
     * @return mixed
     */
    public function extract($value, $context)
    {
        return $value;
    }

    /**
     * @param mixed $value
     * @param mixed $context
     *
     * @return mixed
     */
    public function hydrate($value, $context)
    {
        $func = $this->hydrateFunc;

        return $func($value, $context);
    }
}
