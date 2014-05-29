<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\IP;
use stdClass;

/**
 * @group   assert.ip
 */
class IPTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array('210.132.31.43', true),
            array('210.132.31.4323', 'test is invalid'),
            array('skfsldf', 'test is invalid'),
            array('192.168.0.1', 'test is invalid'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers Harp\Validate\Assert\IP::execute
     */
    public function testExecute($value, $expected)
    {
        $assertion = new IP('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    public function testConstruct()
    {
        $assertion = new IP('test', 'custom message');
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
