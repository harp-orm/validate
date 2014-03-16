<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\Number;
use stdClass;

/**
 * @group   assert.number
 */
class NumberTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return array(
            array('10', Number::INTEGER, true),
            array('1111110', Number::INTEGER, true),
            array('100,2000', Number::INTEGER, false),
            array('10.3', Number::INTEGER, false),
            array('name', Number::INTEGER, false),
            array('/sadfasfdask5843cm', Number::INTEGER, false),
            array('10.2', Number::FLOAT, true),
            array('10.20', Number::FLOAT, true),
            array('ass10.20', Number::FLOAT, false),
            array('20.back', Number::FLOAT, false),
            array('20,20', Number::FLOAT, false),
        );
    }

    /**
     * @dataProvider dataIsValid
     * @covers CL\Carpo\Assert\Number::isValid
     */
    public function testIsValid($number, $type, $expected)
    {
        $this->assertSame($expected, Number::isValid($type, $number));
    }

    public function dataExecute()
    {
        return array(
            array('10', Number::INTEGER, true),
            array('10.2', Number::INTEGER, 'test is an invalid number'),
            array('10.2', Number::FLOAT, true),
            array('black', Number::FLOAT, 'test is an invalid number'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\Number::execute
     */
    public function testExecute($value, $type, $expected)
    {
        $assertion = new Number('test', $type);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\Number::__construct
     * @covers CL\Carpo\Assert\Number::isStrict
     */
    public function testConstruct()
    {
        $assertion = new Number('test', Number::INTEGER, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertSame(Number::INTEGER, $assertion->getType());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
