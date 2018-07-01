<?php

namespace DataMapper\Hydrator\Strategy;

use DataMapper\Hydrator\Exception\InvalidArgumentException;

/**
 * Interface StrategyInterface
 */
interface StrategyInterface
{
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
