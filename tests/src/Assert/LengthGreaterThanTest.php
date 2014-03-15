<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\LengthGreaterThan;
use stdClass;

/**
 * @group   assert.length_greater_than
 */
class LengthGreaterThanTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array('something', 4, true),
            array('something', 10, 'test should be more than 10 letters'),
            array('something', 9, 'test should be more than 9 letters'),
            array('тест', 3, true),
            array('тест', 10, 'test should be more than 10 letters'),
            array('тест', 4, 'test should be more than 4 letters'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\LengthGreaterThan::execute
     */
    public function testExecute($value, $length, $expected)
    {
        $assertion = new LengthGreaterThan('test', $length);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers CL\Carpo\Assert\LengthGreaterThan::__construct
     * @covers CL\Carpo\Assert\LengthGreaterThan::getLength
     */
    public function testConstruct()
    {
        $assertion = new LengthGreaterThan('test', 9, 'custom message');

        $this->assertEquals(9, $assertion->getLength());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
