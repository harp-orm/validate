<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\Email;
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
     * @covers CL\Carpo\Assert\Email::isValid
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
     * @covers CL\Carpo\Assert\Email::isValidStrict
     */
    public function testIsValidStrict($email, $expected)
    {
        $this->assertSame($expected, Email::isValidStrict($email));
    }

    public function dataExecute()
    {
        return array(
            array('test@example.com', null, true),
            array('test+test@example.com', null, true),
            array('test', null, 'test should be a valid email'),
            array('"Abc\@def"@example.com', null, 'test should be a valid email'),
            array('"Abc\@def"@example.com', Email::STRICT, true),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\Email::execute
     */
    public function testExecute($value, $type, $expected)
    {
        $assertion = new Email('test', $type);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\Email::__construct
     * @covers CL\Carpo\Assert\Email::isStrict
     */
    public function testConstruct()
    {
        $assertion = new Email('test', Email::STRICT, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertTrue($assertion->isStrict(), $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
