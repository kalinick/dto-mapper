<?php

namespace MapperBundle\Hydrator;

use MapperBundle\Hydrator\Exception\DuplicateTypeException;

/**
 * Class HydratorRegistry
 */
class HydratorRegistry
{
    private const ALL_TYPE = '*';

    /**
     * @var array
     */
    private $hydrators = [];

    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return AbstractHydrator
     */
    public function getHydrator($source, $destination): AbstractHydrator
    {
        $type = self::formatHydratorType($source, $destination);

        if (!$this->contains($type)) {
            return $this->getBaseHydrator();
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
     * @return AbstractHydrator
     */
    public function getBaseHydrator(): AbstractHydrator
    {
        return $this->hydrators[self::ALL_TYPE];
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
