<?php

namespace MapperBundle\Hydrator\Strategy;

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
     * @param string $propertyName
     * @param string $destination
     * @param mixed  $value
     *
     * @return mixed
     */
    public function hydrate(string $propertyName, string $destination, $value);
}
