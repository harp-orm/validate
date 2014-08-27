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
    public function dataIsValidStatic()
    {
        return [
            ['test@example.com', true],
            ['test+test@example.com', true],
            ['test+132test@example99.co.uk', true],
            ['_somename@example.com', true],
            ['Ahmed.Kemal@google.com', true],
            ['"Abc@def"@example.com', false],
            ['customer/department=shipping@example.com', false],
            ['"Abc\@def"@example.com', false],
        ];
    }

    /**
     * @dataProvider dataIsValidStatic
     * @covers ::isValidNormal
     */
    public function testIsValidNormal($email, $expected)
    {
        $this->assertSame($expected, Email::isValidNormal($email));
    }

    public function dataIsValidStrict()
    {
        return [
            ['test@example.com', true],
            ['test+test@example.com', true],
            ['test+132test@example99.co.uk', true],
            ['_somename@example.com', true],
            ['Ahmed.Kemal@google.com', true],
            ['"Abc@def"@example.com', true],
            ['customer/department=shipping@example.com', true],
            ['"Abc\@def"@example.com', true],
        ];
    }

    /**
     * @dataProvider dataIsValidStrict
     * @covers ::isValidStrict
     */
    public function testIsValidStrict($email, $expected)
    {
        $this->assertSame($expected, Email::isValidStrict($email));
    }

    public function dataExecute()
    {
        return [
            ['test@example.com', Email::NORMAL, true],
            ['test+test@example.com', Email::NORMAL, true],
            ['test', Email::NORMAL, 'test should be a valid email'],
            ['"Abc\@def"@example.com', Email::NORMAL, 'test should be a valid email'],
            ['"Abc\@def"@example.com', Email::STRICT, true],
        ];
    }

    /**
     * @dataProvider dataExecute
     * @covers ::isValid
     */
    public function testExecute($value, $type, $expected)
    {
        $assertion = new Email('test', $type);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @dataProvider dataExecute
     * @covers ::__construct
     * @covers ::isStrict
     */
    public function testConstruct()
    {
        $assertion = new Email('test', Email::STRICT, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertTrue($assertion->isStrict());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
