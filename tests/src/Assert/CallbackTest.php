<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\Callback;

/**
 * @group   assert.callback
 */
class CallbackTest extends AbstractTestCase
{
    public function dataExecute()
    {
        $closure = function($value) {
            return $value === 'test12';
        };

        return array(
            array('10', 'is_numeric', true),
            array('black', 'is_numeric', 'test is invalid'),
            array(10, 'is_int', true),
            array('black', 'is_int', 'test is invalid'),
            array('test12', $closure, true),
            array('test122', $closure, 'test is invalid'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\Callback::execute
     */
    public function testExecute($value, $callback, $expected)
    {
        $assertion = new Callback('test', $callback);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers CL\Carpo\Assert\Callback::__construct
     * @covers CL\Carpo\Assert\Callback::getLength
     */
    public function testConstruct()
    {
        $assertion = new Callback('test', 'is_numeric', 'custom message');

        $this->assertEquals('is_numeric', $assertion->getCallback());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());

        $this->setExpectedException('InvalidArgumentException');

        new Callback('test', 'invalid callback');
    }
}
