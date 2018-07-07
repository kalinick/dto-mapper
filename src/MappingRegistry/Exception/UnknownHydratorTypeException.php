<?php

namespace DataMapper\MappingRegistry\Exception;

/**
 * Class UnknownHydratorTypeException
 */
final class UnknownHydratorTypeException extends \BadMethodCallException
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
