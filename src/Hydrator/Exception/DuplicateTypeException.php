<?php

namespace MapperBundle\Hydrator\Exception;

/**
 * Class DuplicateTypeException
 */
class DuplicateTypeException extends HydratorException
{
    /**
     * @var string
     */
    protected $message = 'Hydrator type: %s already registered';

    /**
     * DuplicateRegisterException constructor.
     *
     * @param string          $type
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $type, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(sprintf($this->message, $type), $code, $previous);
    }
}
