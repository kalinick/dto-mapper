<?php

namespace DataMapper\Strategy;

use DataMapper\Exception\InvalidArgumentException;
use DataMapper\Strategy\Exception\EmptyXPathException;
use DataMapper\Hydrator\ExtractionInterface;

/**
 * Class GetterStrategy
 */
class XPathGetterStrategy implements StrategyInterface
{
    private const DELIMITER = '.';

    /**
     * @var array
     */
    private $xPathParts;

    /**
     * @var ExtractionInterface
     */
    private $extractor;

    /**
     * XPathGetterStrategy constructor.
     *
     * @param ExtractionInterface $extractor
     * @param string              $path
     * @param string              $delimiter
     */
    public function __construct(ExtractionInterface $extractor, string $path, string $delimiter = self::DELIMITER)
    {
        if (!\substr_count($path, $delimiter)) {
            throw new EmptyXPathException($path);
        }

        $this->xPathParts = \explode($delimiter, $path);
        $this->extractor = $extractor;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($value, $context)
    {
        [$sourceContext, $propertyName] = $context;

        if (!\is_object($sourceContext)) {
            throw new InvalidArgumentException('$value - argument must be object');
        }

        $extracted = $this->extractor->extract($sourceContext);
        foreach ($this->xPathParts as $step => $key) {
            if (!isset($extracted[$key])) {
                return null;
            }

            if (!\is_object($extracted[$key])) {
                $extracted = $extracted[$key];
            } else {
                $extracted = $this->extractor->extract($extracted[$key]);
            }
        }

        return $extracted;
    }
}
