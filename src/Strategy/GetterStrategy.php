<?php

namespace DataMapper\Strategy;

use DataMapper\Exception\InvalidArgumentException;

/**
 * Class GetterStrategy
 */
final class GetterStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    private $methodToCall;

    /**
     * GetterStrategy constructor.
     *
     * @param string $methodToCall
     */
    public function __construct(string $methodToCall)
    {
        $this->methodToCall = $methodToCall;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($value, $context)
    {
        if (!\is_object($value)) {
            throw new InvalidArgumentException('$value - argument must be object');
        }
        if (!\is_callable([$value, $this->methodToCall])) {
            throw new InvalidArgumentException(
                \get_class($value) .
                "- getter method: {$this->methodToCall} must be callable"
            );
        }

        return $value->{$this->methodToCall}();
    }
}
