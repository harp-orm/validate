<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\LengthBetween;
use stdClass;

/**
 * @group   assert.length_between
 */
class LengthBetweenTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array('something', 4,  20, true),
            array('something', 10, 20, 'test should be between 10 and 20 letters'),
            array('something', 3, 5, 'test should be between 3 and 5 letters'),
            array('something', 9, 10, true),
            array('something', 7, 9, true),
            array('тест', 3,  10, true),
            array('тест', 10, 20, 'test should be between 10 and 20 letters'),
            array('тест', 2, 3, 'test should be between 2 and 3 letters'),
            array('тест', 4, 10, true),
            array('тест', 2, 4, true),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\LengthBetween::execute
     */
    public function testExecute($value, $min, $max, $expected)
    {
        $assertion = new LengthBetween('test', $min, $max);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers CL\Carpo\Assert\LengthBetween::__construct
     * @covers CL\Carpo\Assert\LengthBetween::getLength
     */
    public function testConstruct()
    {
        $assertion = new LengthBetween('test', 4, 5, 'custom message');

        $this->assertEquals(4, $assertion->getMin());
        $this->assertEquals(5, $assertion->getMax());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());

        $this->setExpectedException('InvalidArgumentException');

        new LengthBetween('test', 4, 2);
    }
}
