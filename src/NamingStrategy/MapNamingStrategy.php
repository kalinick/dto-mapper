<?php

namespace DataMapper\NamingStrategy;

use DataMapper\Exception\InvalidArgumentException;

/**
 * Class MapNamingStrategy
 */
class MapNamingStrategy implements NamingStrategyInterface
{
    /**
     * Map for hydrate name conversion.
     *
     * @var array
     */
    protected $mapping = [];

    /**
     * Reversed map for extract name conversion.
     *
     * @var array
     */
    protected $reverse = [];

    /**
     * Initialize.
     *
     * @param array      $mapping Map for name conversion on hydration
     * @param array|null $reverse Reverse map for name conversion on extraction
     */
    public function __construct(array $mapping, ?array $reverse)
    {
        $this->mapping = $mapping;
        $this->reverse = $reverse ?: $this->flipMapping($mapping);
    }

    /**
     * Safely flip mapping array.
     *
     * @param  array                    $array Array to flip
     * @return array                    Flipped array
     * @throws InvalidArgumentException
     */
    protected function flipMapping(array $array): array
    {
        \array_walk($array, function ($value) {
            if (!\is_string($value) && !\is_int($value)) {
                throw new InvalidArgumentException('Mapping array can\'t be flipped because of invalid value');
            }
        });

        return \array_flip($array);
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate(string $name, $context = null): string
    {
        if (\array_key_exists($name, $this->mapping)) {
            return $this->mapping[$name];
        }

        return $name;
    }

    /**
     * {@inheritDoc}
     */
    public function extract(string $name): string
    {
        if (\array_key_exists($name, $this->reverse)) {
            return $this->reverse[$name];
        }

        return $name;
    }
}
