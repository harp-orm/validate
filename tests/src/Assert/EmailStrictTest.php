<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\EmailStrict;
use stdClass;

/**
 * @group   assert.email
 * @coversDefaultClass Harp\Validate\Assert\EmailStrict
 */
class EmailStrictTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            ['test@example.com', true],
            ['"Abc@def"@example.com', true],
            ['customer/department=shipping@example.com', true],
            ['"Abc\@def"@example.com', true],
            ['test', 'test should be a valid email'],
            ['"Abc\@def"@example.com', true],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $expected)
    {
        $assertion = new EmailStrict('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $assertion = new EmailStrict('test', 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
