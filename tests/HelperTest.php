<?php

declare(strict_types=1);

namespace Test;

use Collection\Exception\Internal\HelperException;
use Collection\Helper;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\EntityInterfaceCollection;
use Tests\Fixtures\SecondEntityCollection;
use Tests\Fixtures\Unsupported\EmptyClass;

class HelperTest extends TestCase
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
     * @throws HelperException
     *
     * @group ok
     * @dataProvider dpGetConstructorFirstParameterClassNameFunctionThrowsHelperException
     */
    public function testGetConstructorFirstParameterClassNameFunctionThrowsHelperException(
        object $class,
        string $className,
    ): void {
        try {
            Helper::getConstructorFirstParameterClassName($class);
        } catch (HelperException $exception) {
            $this->assertEquals($className, $exception->getItemClassName());
        }

        $this->expectException(HelperException::class);
        Helper::getConstructorFirstParameterClassName($class);
    }

    public function dpGetConstructorFirstParameterClassNameFunctionThrowsHelperException(): array
    {
        return [
            [
                new EmptyClass(),
                'Tests\Fixtures\Unsupported\EmptyClass',
            ],
        ];
    }
}
