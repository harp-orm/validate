<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\InArray;

/**
 * @group   assert.in_array
 */
class InArrayTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array('10', array('10', '20'), true),
            array('20', array('10', '20'), true),
            array('30', array('10', '20'), 'test is invalid'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\InArray::execute
     */
    public function testExecute($value, $array, $expected)
    {
        $assertion = new InArray('test', $array);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers CL\Carpo\Assert\InArray::__construct
     * @covers CL\Carpo\Assert\InArray::getArray
     */
    public function testConstruct()
    {
        $assertion = new InArray('test', array('test1', 'test2'), 'custom message');

        $this->assertEquals(array('test1', 'test2'), $assertion->getArray());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());

        $this->setExpectedException('InvalidArgumentException');

        new InArray('test', array());
    }
}
