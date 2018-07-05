<?php

namespace DataMapper\Hydrator\Exception;

/**
 * Class EmptyXPathException
 */
final class EmptyXPathException extends HydratorException
{
    /**
     * DuplicateRegisterException constructor.
     *
     * @param string          $path
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $path, int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('Xpath: %s strategy is empty', $path);
        parent::__construct($message, $code, $previous);
    }
}
