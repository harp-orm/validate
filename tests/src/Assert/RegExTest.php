<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\RegEx;
use stdClass;

/**
 * @group   assert.reg_ex
 * @coversDefaultClass Harp\Validate\Assert\RegEx
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
     * @covers ::execute
     */
    public function testExecute($value, $pattern, $expected)
    {
        $assertion = new RegEx('test', $pattern);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getPattern
     */
    public function testConstruct()
    {
        $assertion = new RegEx('test', '/some pattern/', 'custom message');

        $this->assertEquals('/some pattern/', $assertion->getPattern());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
