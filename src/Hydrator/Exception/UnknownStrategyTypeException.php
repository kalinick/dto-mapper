<?php

namespace DataMapper\Hydrator\Exception;

/**
 * Class UnknownStrategyTypeException
 */
final class UnknownStrategyTypeException extends HydratorException
{
    /**
     * DuplicateRegisterException constructor.
     *
     * @param string         $type
     * @param int            $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $type, int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('Strategy type: %s not registered', $type);
        parent::__construct($message, $code, $previous);
    }
}
