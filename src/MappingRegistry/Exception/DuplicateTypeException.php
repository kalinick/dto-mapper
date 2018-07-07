<?php

namespace DataMapper\MappingRegistry\Exception;

/**
 * Class DuplicateTypeException
 */
final class DuplicateTypeException extends \BadMethodCallException
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
        $message = sprintf('%s:  %s - already registered', static::class, $type);
        parent::__construct($message, $code, $previous);
    }
}
