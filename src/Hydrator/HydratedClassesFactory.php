<?php

namespace DataMapper\Hydrator;

use GeneratedHydrator\Configuration;

/**
 * Class HydratedClassesFactory
 */
class HydratedClassesFactory
{
    /**
     * @var null|string
     */
    private static $targerDir = null;

    /**
     * @param string $className
     *
     * @return HydratorInterface
     */
    public static function creareHydratorClass(string $className): object
    {
        $hydratedClassName = self::createHydratedClass($className);

        return new $hydratedClassName();
    }

    /**
     * @param string $className
     *
     * @return string
     */
    public static function createHydratedClass(string $className): string
    {
        $config = new Configuration($className);

        if (null !== self::$targerDir) {
            $config->setGeneratedClassesTargetDir(self::$targerDir);
        }

        return $config->createFactory()->getHydratorClass();
    }

    /**
     * @param string $dirPath
     */
    public static function setGeneratedClassesTargetDir(string $dirPath): void
    {
        self::$targerDir = $dirPath;
    }
}
