<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\IsInteger;
use stdClass;

/**
 * @group   assert.number
 * @coversDefaultClass Harp\Validate\Assert\IsInteger
 */
class IsIntegerTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            ['10', true],
            [10, true],
            ['1111110', true],
            ['100,2000', 'test should be a valid number'],
            ['10.3', 'test should be a valid number'],
            [10.3, 'test should be a valid number'],
            ['name', 'test should be a valid number'],
            ['/sadfasfdask5843cm', 'test should be a valid number'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $expected)
    {
        $assertion = new IsInteger('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $assertion = new IsInteger('test', 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
