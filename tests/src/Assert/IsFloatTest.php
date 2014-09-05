<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\IsFloat;
use stdClass;

/**
 * @group   assert.number
 * @coversDefaultClass Harp\Validate\Assert\IsFloat
 */
class IsFloatTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            ['10.2', true],
            [10.2, true],
            [10, true],
            ['10.20', true],
            ['ass10.20', 'test should be a valid number'],
            ['20.back', 'test should be a valid number'],
            ['20,20', 'test should be a valid number'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $expected)
    {
        $assertion = new IsFloat('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $assertion = new IsFloat('test', 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
