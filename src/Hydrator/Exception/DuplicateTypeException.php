<?php

namespace DataMapper\Hydrator\Exception;

/**
 * Class DuplicateTypeException
 */
final class DuplicateTypeException extends HydratorException
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
        $message = sprintf('Hydrator type: %s already registered', $type);
        parent::__construct($message, $code, $previous);
    }
}
