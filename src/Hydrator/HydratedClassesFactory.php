<?php

namespace DataMapper\Hydrator;

use GeneratedHydrator\Configuration;

/**
 * Class HydratedClassesFactory
 */
class HydratedClassesFactory
{
    /**
     * @var string
     */
    private $targetDir;

    /**
     * HydratedClassesFactory constructor.
     *
     * @param null|string $targetDir
     */
    public function __construct(?string $targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * @param string $className
     *
     * @return HydratorInterface
     */
    public function createHydratorClass(string $className): object
    {
        $hydratedClassName = $this->extractHydratedClass($className);

        return new $hydratedClassName();
    }

    /**
     * @param string $className
     *
     * @return string
     */
    public function extractHydratedClass(string $className): string
    {
        $config = new Configuration($className);

        if (null !== $this->targetDir) {
            $config->setGeneratedClassesTargetDir($this->targetDir);
            \spl_autoload_register($config->getGeneratedClassAutoloader());
        }

        $className =  $config->createFactory()->getHydratorClass();

        return $className;
    }
}
