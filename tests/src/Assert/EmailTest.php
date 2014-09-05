<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\Email;
use stdClass;

/**
 * @group   assert.email
 * @coversDefaultClass Harp\Validate\Assert\Email
 */
class EmailTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            ['test@example.com', true],
            ['test+test@example.com', true],
            ['test+132test@example99.co.uk', true],
            ['_somename@example.com', true],
            ['Ahmed.Kemal@google.com', true],
            ['"Abc@def"@example.com', 'test should be a valid email'],
            ['customer/department=shipping@example.com', 'test should be a valid email'],
            ['"Abc\@def"@example.com', 'test should be a valid email'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValidStrict($value, $expected)
    {
        $assertion = new Email('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $assertion = new Email('test', 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
