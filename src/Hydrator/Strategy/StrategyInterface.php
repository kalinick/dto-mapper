<?php

namespace MapperBundle\Hydrator\Strategy;

use MapperBundle\Hydrator\Exception\InvalidArgumentException;

/**
 * Interface StrategyInterface
 */
interface StrategyInterface
{
    /**
     * @param mixed $value
     * @param mixed $context
     *
     * @return mixed
     */
    public function extract($value, $context);

    /**
     * @throws InvalidArgumentException
     *
     * @param mixed $value
     * @param mixed $context
     *
     * @return mixed
     */
    public function hydrate($value, $context);
}
