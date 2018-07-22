<?php

namespace DataMapper\Aggregation\Specification;

/**
 * Class IncrementValueSpecification
 */
class IncrementValueSpecification
{
    /**
     * @return \Closure
     */
    public static function create(): \Closure
    {
        return function (int $value, ?int $incr = 1): int {
            return $value + $incr;
        };
    }
}
