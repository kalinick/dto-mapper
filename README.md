
Dto mapper bundle. (*in development*)

Expand opportunities of Ocramius/GeneratedHydrator See [here](https://github.com/Ocramius/GeneratedHydrator)
Uses flexibility of zendframework/zend-hydrator See [here](https://github.com/zendframework/zend-hydrator)

For now work with directions:
- Array to Object
- Array to ClassName
- Object to Array
 

```bash
$ composer require vklymniuk/dto-mapper
```

Just mark your destination class by meta annotations and push your array to MapperClass.

```php
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
     * @PropertyClassRelation(targetClass="Tests\DataFixtures\Dto\Destination\RegistrationRequestDto", multiply="true")
     *
     * @var RegistrationRequestDto[]
     */
    public $registrationsRequests = [];

    /**
     * @PropertyClassRelation(targetClass="Tests\DataFixtures\Dto\Destination\PersonalInfoDto")
     *
     * @var PersonalInfoDto
     */
    public $personalInfo;

    /**
     * @var array
     */
    public $extra = [];
}    
``` 