<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\LengthGreaterThan;
use stdClass;

/**
 * @group   assert.length_greater_than
 * @coversDefaultClass Harp\Validate\Assert\LengthGreaterThan
 */
class LengthGreaterThanTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            ['something', 4, true],
            ['something', 10, 'test should be more than 10 letters'],
            ['something', 9, 'test should be more than 9 letters'],
            ['тест', 3, true],
            ['тест', 10, 'test should be more than 10 letters'],
            ['тест', 4, 'test should be more than 4 letters'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $length, $expected)
    {
        $assertion = new LengthGreaterThan('test', $length);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $assertion = new LengthGreaterThan('test', 9, 'custom message');

        $this->assertEquals(9, $assertion->getLength());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
