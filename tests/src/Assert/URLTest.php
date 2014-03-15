<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\URL;
use stdClass;

/**
 * @group   assert.url
 */
class URLTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return array(
            array('http://example.com', true),
            array('http://www.example.com/test.html', true),
            array('https://www.example.com/test.html', true),
            array('bitcoin://www.example.com/test.html', true),
            array('chrome://history', true),
            array('http://user:pass@www.example.com', true),
            array('http://userid:password@example.com/', true),
            array('http://user@www.example.com', true),
            array('http://142.42.1.1:8080/', true),
            array('http://foo.com/blah_(wikipedia)#cite-1', true),
            array('http://www.example.com/wpstyle/?p=364', true),
            array('https://www.example.com/foo/?bar=baz&inga=42&quux', true),
            array('http://foo.bar/?q=Test%20URL-encoded%20stuff', true),
            array('http://foo.com/unicode_(✪)_in_parens', true),
            array('ftp://example-example.co.uk', true),
            array('ftp://90.190.32.12', true),
            array('ftp://90.190.32.12/test.html', true),
            array('http://'.str_pad('example-', 50, 'a').'.com', true),
            array('http://user:@pass@www.example.com', false),
            array('http://user:pa:ss@www.example.com', false),
            array('http://'.str_pad('example-', 70, 'a').'.com', false),
            array('ftp://example-example.co.1k', false),
            array('http://foo.bar?q=Spaces should be encoded', false),
            array(':// should fail', false),
            array('http://.www.foo.bar/', false),
            array('http://.www.foo.bar./', false),
        );
    }

    /**
     * @dataProvider dataIsValid
     * @covers CL\Carpo\Assert\URL::isValid
     */
    public function testIsValid($email, $expected)
    {
        $this->assertSame($expected, URL::isValid($email));
    }

    public function dataExecute()
    {
        return array(
            array('http://example.com', true),
            array('http://user:pass@www.example.com', true),
            array('example', 'test should be a valid URL address'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\URL::execute
     */
    public function testExecute($value, $expected)
    {
        $assertion = new URL('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    public function testConstruct()
    {
        $assertion = new URL('test', 'custom message');
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
