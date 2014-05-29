<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\InArray;

/**
 * @group   assert.in_array
 * @coversDefaultClass Harp\Validate\Assert\InArray
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
     * @covers ::execute
     */
    public function testExecute($value, $array, $expected)
    {
        $assertion = new InArray('test', $array);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getArray
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
