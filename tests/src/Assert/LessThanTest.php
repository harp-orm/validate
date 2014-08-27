<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\LessThan;
use stdClass;

/**
 * @group   assert.less_than
 * @coversDefaultClass Harp\Validate\Assert\LessThan
 */
class LessThanTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            [3, 4, true],
            [11, 10, 'test should be less than 10'],
            [9, 9, 'test should be less than 9'],
            [4, 4.3, true],
            [10, 9.66, 'test should be less than 9.66'],
            [8.12, 9.2, true],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $length, $expected)
    {
        $assertion = new LessThan('test', $length);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getValue
     * @covers ::getMessageParameters
     */
    public function testConstruct()
    {
        $assertion = new LessThan('test', 9, 'custom message');

        $this->assertEquals(9, $assertion->getValue());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals([':name' => 'test', ':value' => 9], $assertion->getMessageParameters());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
