<?php

namespace MapperBundle\Hydrator\Exception;

use Throwable;

/**
 * Class UnknownStrategyTypeException
 */
class UnknownStrategyTypeException extends HydratorException
{
    /**
     * @var string
     */
    protected $message = 'Strategy type: %s not registered';

    /**
     * DuplicateRegisterException constructor.
     *
     * @param string         $type
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $type, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf($this->message, $type), $code, $previous);
    }
}
