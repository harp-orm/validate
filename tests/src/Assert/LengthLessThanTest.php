<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\LengthLessThan;
use stdClass;

/**
 * @group   assert.length_less_than
 */
class LengthLessTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array('something', 20, true),
            array('something', 10, true),
            array('something', 9, 'test should be less than 9 letters'),
            array('something', 4, 'test should be less than 4 letters'),
            array('тест', 10, true),
            array('тест', 5, true),
            array('тест', 4, 'test should be less than 4 letters'),
            array('тест', 3, 'test should be less than 3 letters'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\LengthLessThan::execute
     */
    public function testExecute($value, $length, $expected)
    {
        $assertion = new LengthLessThan('test', $length);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers CL\Carpo\Assert\LengthLessThan::__construct
     * @covers CL\Carpo\Assert\LengthLessThan::getLength
     */
    public function testConstruct()
    {
        $assertion = new LengthLessThan('test', 9, 'custom message');

        $this->assertEquals(9, $assertion->getLength());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
