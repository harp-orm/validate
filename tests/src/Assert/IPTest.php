<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\IP;
use stdClass;

/**
 * @group   assert.ip
 * @coversDefaultClass Harp\Validate\Assert\IP
 */
class IPTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            ['210.132.31.43', true],
            ['210.132.31.4323', 'test is invalid'],
            ['skfsldf', 'test is invalid'],
            ['192.168.0.1', 'test is invalid'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $expected)
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
