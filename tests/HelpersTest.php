<?php

declare(strict_types=1);

namespace Test;

use Collection\Exception\CollectionException\InvalidConstructorDeclarationException;
use Collection\Helper;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\EntityInterfaceCollection;
use Tests\Fixtures\SecondEntityCollection;
use Tests\Fixtures\Unsupported\EmptyClass;

use function sprintf;

class HelpersTest extends TestCase
{
    /**
     * @group ok
     * @dataProvider dpGetConstructorFirstParameterClassNameFunctionSuccess
     */
    public function testGetConstructorFirstParameterClassNameFunction(object $class, string $expected): void
    {
        $this->assertEquals(Helper::getConstructorFirstParameterClassName($class), $expected);
    }

    public function dpGetConstructorFirstParameterClassNameFunctionSuccess(): array
    {
        return [
            [
                new SecondEntityCollection(),
                'Tests\Fixtures\Entities\SecondEntity',
            ],
            [
                new EntityInterfaceCollection(),
                'Tests\Fixtures\Entities\EntityInterface',
            ],
        ];
    }

    /**
     * @throws InvalidConstructorDeclarationException
     *
     * @group ok
     * @dataProvider dpGetConstructorFirstParameterClassNameFunctionThrowsInvalidConstructorDeclarationException
     */
    public function testGetConstructorFirstParameterClassNameFunctionThrowsDtoCollectionConstructorException(
        object $class,
        string $className,
    ): void {
        $this->expectException(InvalidConstructorDeclarationException::class);
        $this->expectExceptionMessage(
            sprintf('Collection: %s | Err: Invalid constructor declaration', $className),
        );
        $this->expectExceptionCode(300);

        Helper::getConstructorFirstParameterClassName($class);
    }

    public function dpGetConstructorFirstParameterClassNameFunctionThrowsInvalidConstructorDeclarationException(): array
    {
        return [
            [
                new EmptyClass(),
                'Tests\Fixtures\Unsupported\EmptyClass',
            ],
        ];
    }
}
