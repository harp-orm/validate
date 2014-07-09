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
    public function dataExecute()
    {
        return array(
            array(3, 4, true),
            array(11, 10, 'test should be less than 10'),
            array(9, 9, 'test should be less than 9'),
            array(4, 4.3, true),
            array(10, 9.66, 'test should be less than 9.66'),
            array(8.12, 9.2, true),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers ::execute
     */
    public function testExecute($value, $length, $expected)
    {
        $assertion = new LessThan('test', $length);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getValue
     */
    public function testConstruct()
    {
        $assertion = new LessThan('test', 9, 'custom message');

        $this->assertEquals(9, $assertion->getValue());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}