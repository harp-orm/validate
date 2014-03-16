<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\RegEx;
use stdClass;

/**
 * @group   assert.reg_ex
 */
class RegExTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array('something', '/\w/', true),
            array('something more', '/^\w$/', 'test is invalid'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\RegEx::execute
     */
    public function testExecute($value, $pattern, $expected)
    {
        $assertion = new RegEx('test', $pattern);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers CL\Carpo\Assert\RegEx::__construct
     * @covers CL\Carpo\Assert\RegEx::getPattern
     */
    public function testConstruct()
    {
        $assertion = new RegEx('test', '/some pattern/', 'custom message');

        $this->assertEquals('/some pattern/', $assertion->getPattern());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
