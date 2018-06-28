# dto-mapper
[![Build Status](https://travis-ci.org/vklymniuk/dto-mapper.svg?branch=master)](https://travis-ci.org/vklymniuk/dto-mapper)


# MapperBundle (*in progress*)

Use generated-hydrator to create or extract objects. 

## Installation
```bash
$ composer require vklymniuk/dto-mapper
```

```php

Setup you destination classes by meta annotations like:

<?php

use MapperBundle\Mapping\Annotation\Meta\PropertyClassRelation;
use MapperBundle\Mapping\Annotation\Meta\DestinationClass;

/**
 * Class RelationsRequestDto
 * @DestinationClass
 */
class RelationsRequestDto
{
    /**
     * Contains collection of RegistrationRequestDto
     * @PropertyClassRelation(targetClass="App\Dto\Destination\RegistrationRequestDto", multiply="true")
     */
    public $registrationsRequests = [];

    /**
     * Contains single object
     * @PropertyClassRelation(targetClass="App\Dto\Destination\PersonalInfoDto")
     */
    public $personalInfo;

    /**
     * @var array
     */
    public $extra = [];
}    
``` 

 ```yaml
 Mark registered classes by tag
  
 tags:
    - dto_mapper.destination
``` 

```tex
use HydratorFactory::createBuilder($source, $destination): HydratorBuilderInterface; 
to create create your custom hydrator

```
```php
<?php
    
namespace MapperBundle\Hydrator;

use MapperBundle\Hydrator\NamingStrategy\NamingStrategyInterface;
use MapperBundle\Hydrator\Strategy\StrategyInterface;

/**
 * Interface HydratorBuilderInterface
 */
interface HydratorBuilderInterface
{
    /**
     * @param NamingStrategyInterface $namingStrategy
     *
     * @return HydratorBuilderInterface
     */
    public function setNamingStrategy(NamingStrategyInterface $namingStrategy): HydratorBuilderInterface;

    /**
     * @param string            $name
     * @param StrategyInterface $strategy
     *
     * @return HydratorBuilderInterface
     */
    public function addStrategy(string $name, StrategyInterface $strategy): HydratorBuilderInterface;

    /**
     * @return HydratorBuilderInterface
     */
    public function removeNamingStrategy(): HydratorBuilderInterface;

    /**
     * @param string $name
     *
     * @return HydratorBuilderInterface
     */
    public function removeStrategy(string $name): HydratorBuilderInterface;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasStrategy(string $name): bool;

    /**
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface;
}
``` 

```text
use HydratorFactory::createHydrator($source, $destination): HydratorInterface 
to create from configured

'@MapperBundle\Mapper\MapperInterface' - to inject mapper in your service
``` 

```php
<?php

namespace MapperBundle\Mapper;

/**
 * Interface MapperInterface
 */
interface MapperInterface
{
    /**
     * @param array|object        $source
     * @param object|string|array $destination
     *
     * @return object|array
     */
    public function convert($source, $destination);

    /**
     * @param object $source
     *
     * @return array
     */
    public function extract(object $source): array;
}

``` 

See examples of usage: See [here](https://github.com/vklymniuk/dto-mapper/blob/master/src/Resource/docs/examples/array-to-array)
- 
- See mapping anotations : See [here](https://github.com/vklymniuk/dto-mapper/blob/master/tests/DataFixtures/Dto/Destination/RelationsRequestDto.php)


Use code generators from p Ocramius/GeneratedHydrator See [here](https://github.com/Ocramius/GeneratedHydrator)
 