<?php

namespace DataMapper\Hydrator\Exception;

/**
 * Class DestinationTypeException
 */
final class DestinationTypeException extends HydratorException
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
        $message = sprintf('Destination type: %s not supported by %s', $type, static::class);
        parent::__construct($message, $code, $previous);
    }
}
