<?php

namespace MapperBundle\Hydrator\Exception;

/**
 * Class DestinationTypeException
 */
class DestinationTypeException extends HydratorException
{
    /**
     * @var string
     */
    protected $message = 'Destination type: %s not supported by %s';

    /**
     * DuplicateRegisterException constructor.
     *
     * @param string          $type
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $type, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(sprintf($this->message, $type, get_called_class()), $code, $previous);
    }
}
