<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\Number;
use stdClass;

/**
 * @group   assert.number
 * @coversDefaultClass Harp\Validate\Assert\Number
 */
class NumberTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            ['10', Number::INTEGER, true],
            [10, Number::INTEGER, true],
            ['1111110', Number::INTEGER, true],
            ['100,2000', Number::INTEGER, 'test is an invalid number'],
            ['10.3', Number::INTEGER, 'test is an invalid number'],
            [10.3, Number::INTEGER, 'test is an invalid number'],
            ['name', Number::INTEGER, 'test is an invalid number'],
            ['/sadfasfdask5843cm', Number::INTEGER, 'test is an invalid number'],
            ['10.2', Number::FLOAT, true],
            [10.2, Number::FLOAT, true],
            [10, Number::FLOAT, true],
            ['10.20', Number::FLOAT, true],
            ['ass10.20', Number::FLOAT, 'test is an invalid number'],
            ['20.back', Number::FLOAT, 'test is an invalid number'],
            ['20,20', Number::FLOAT, 'test is an invalid number'],
            ['20,20', null, 'test is an invalid number'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     * @covers ::isValidInteger
     * @covers ::isValidFloat
     */
    public function testIsValid($value, $type, $expected)
    {
        $assertion = new Number('test', $type);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getType
     */
    public function testConstruct()
    {
        $assertion = new Number('test', Number::INTEGER, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertSame(Number::INTEGER, $assertion->getType());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
