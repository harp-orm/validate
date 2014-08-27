<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\IsInstanceOf;
use stdClass;
use SplObjectStorage;
/**
 * @group   assert.is_instance_of
 * @coversDefaultClass Harp\Validate\Assert\IsInstanceOf
 */
class IsInstanceOfTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            [new SplObjectStorage(), 'SplObjectStorage', true],
            [new stdClass(), 'stdClass', true],
            [new SplObjectStorage(), 'stdClass', 'test is invalid'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $class, $expected)
    {
        $assertion = new IsInstanceOf('test', $class);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getClass
     */
    public function testConstruct()
    {
        $assertion = new IsInstanceOf('test', 'SplObjectStorage', 'custom message');

        $this->assertEquals('SplObjectStorage', $assertion->getClass());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());

        $this->setExpectedException('InvalidArgumentException', 'adsasd should be a valid class or interface');

        new IsInstanceOf('test', 'adsasd');
    }
}
