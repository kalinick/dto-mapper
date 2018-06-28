<?php

namespace Tests\TestCase\Mapping\Annotation;

use MapperBundle\Mapping\Annotation\DestinationMetaReader;
use MapperBundle\Mapping\Annotation\Exception\UndeclaredPropertyException;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use Tests\DataFixtures\Dto\Destination\RelationsRequestDto;

/**
 * Class DestinationMetaReaderTest
 */
class DestinationMetaReaderTest extends TestCase
{
    /**
     * @test
     */
    public function testUndefinedClassMapping()
    {
        $dto = RelationsRequestDto::class . 'bad';
        $annotationReader = new AnnotationReader();

        $this->expectException(\ReflectionException::class);
        DestinationMetaReader::read($annotationReader, $dto);
    }

    /**
     * @test
     */
    public function testRelationsMetaMapping()
    {
        $annotationReader = new AnnotationReader();
        $reader = DestinationMetaReader::read($annotationReader, RelationsRequestDto::class);
        $this->assertTrue($reader->hasPropertyRelations());
        $this->assertTrue($reader->isDestinationClass());
        $this->assertTrue($reader->hasMultiRelations('registrationsRequests'));
        $this->assertFalse($reader->hasMultiRelations('personalInfo'));
        $this->assertFalse($reader->hasPropertyRelation('extra'));
        $this->expectException(UndeclaredPropertyException::class);
        $this->assertFalse($reader->getPropertyTarget('extra'));
    }
}
