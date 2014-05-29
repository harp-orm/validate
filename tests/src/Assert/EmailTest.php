<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\Email;
use stdClass;

/**
 * @group   assert.email
 */
class EmailTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return array(
            array('test@example.com', true),
            array('test+test@example.com', true),
            array('test+132test@example99.co.uk', true),
            array('_somename@example.com', true),
            array('Ahmed.Kemal@google.com', true),
            array('"Abc@def"@example.com', false),
            array('customer/department=shipping@example.com', false),
            array('"Abc\@def"@example.com', false),
        );
    }

    /**
     * @dataProvider dataIsValid
     * @covers Harp\Validate\Assert\Email::isValid
     */
    public function testIsValid($email, $expected)
    {
        $this->assertSame($expected, Email::isValid($email));
    }

    public function dataIsValidStrict()
    {
        return array(
            array('test@example.com', true),
            array('test+test@example.com', true),
            array('test+132test@example99.co.uk', true),
            array('_somename@example.com', true),
            array('Ahmed.Kemal@google.com', true),
            array('"Abc@def"@example.com', true),
            array('customer/department=shipping@example.com', true),
            array('"Abc\@def"@example.com', true),
        );
    }

    /**
     * @dataProvider dataIsValidStrict
     * @covers Harp\Validate\Assert\Email::isValidStrict
     */
    public function testIsValidStrict($email, $expected)
    {
        $this->assertSame($expected, Email::isValidStrict($email));
    }

    public function dataExecute()
    {
        return array(
            array('test@example.com', Email::NORMAL, true),
            array('test+test@example.com', Email::NORMAL, true),
            array('test', Email::NORMAL, 'test should be a valid email'),
            array('"Abc\@def"@example.com', Email::NORMAL, 'test should be a valid email'),
            array('"Abc\@def"@example.com', Email::STRICT, true),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers Harp\Validate\Assert\Email::execute
     */
    public function testExecute($value, $type, $expected)
    {
        $assertion = new Email('test', $type);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @dataProvider dataExecute
     * @covers Harp\Validate\Assert\Email::__construct
     * @covers Harp\Validate\Assert\Email::isStrict
     */
    public function testConstruct()
    {
        $assertion = new Email('test', Email::STRICT, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertTrue($assertion->isStrict());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
