<?php

namespace DataMapper\Hydrator;

use DataMapper\Hydrator\Exception\DuplicateTypeException;
use DataMapper\Hydrator\Exception\UnknownTypeException;

/**
 * Class HydratorRegistry
 */
class HydratorRegistry
{
    /**
     * @var array
     */
    private $hydrators = [];

    /**
     * @throws UnknownTypeException
     *
     * @param mixed $source
     * @param mixed $destination
     *
     * @return AbstractHydrator
     */
    public function getHydrator($source, $destination): AbstractHydrator
    {
        $type = self::formatHydratorType($source, $destination);

        if (!$this->contains($type)) {
            throw new UnknownTypeException($type);
        }

        return $this->hydrators[$type];
    }

    /**
     * @throws DuplicateTypeException
     *
     * @param AbstractHydrator $hydrator
     * @param string           $type
     *
     * @return HydratorRegistry
     */
    public function registerHydrator(AbstractHydrator $hydrator, string $type): self
    {
        if ($this->contains($type)) {
            throw new DuplicateTypeException($type);
        }

        $this->hydrators[$type] = $hydrator;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function contains(string $type): bool
    {
        return isset($this->hydrators[$type]);
    }

    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return string
     */
    public static function formatHydratorType($source, $destination): string
    {
        return self::formatType(\gettype($source), \gettype($destination));
    }

    /**
     * @param string $source
     * @param string $destination
     *
     * @return string
     */
    public static function formatType(string $source, string $destination): string
    {
        return $source . ':' . $destination;
    }
}
