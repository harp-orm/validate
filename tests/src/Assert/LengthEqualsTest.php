<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\LengthEquals;
use stdClass;

/**
 * @group   assert.length_equals
 */
class LengthEqualsTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array('something', 2, 'test should be 2 letters'),
            array('something', 9, true),
            array('тест', 4, true),
            array('тест', 0, 'test should be 0 letters'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\LengthEquals::execute
     */
    public function testExecute($value, $length, $expected)
    {
        $assertion = new LengthEquals('test', $length);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers CL\Carpo\Assert\LengthEquals::__construct
     * @covers CL\Carpo\Assert\LengthEquals::getLength
     */
    public function testConstruct()
    {
        $assertion = new LengthEquals('test', 9, 'custom message');

        $this->assertEquals(9, $assertion->getLength());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
