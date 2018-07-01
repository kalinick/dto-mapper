<?php

namespace DataMapper\Hydrator\Exception;

/**
 * Class UnknownTypeException
 */
final class UnknownTypeException extends HydratorException
{
    /**
     * DuplicateRegisterException constructor.
     *
     * @param string          $type
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $type, int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('Hydrator type: %s not registered', $type);
        parent::__construct($message, $code, $previous);
    }
}
