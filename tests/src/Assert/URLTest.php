<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\URL;
use stdClass;

/**
 * @group   assert.url
 */
class URLTest extends AbstractTestCase
{
    public function dataBuildUrl()
    {
        return array(
            array(
                array(
                    'scheme' => 'http',
                    'host' => 'example.com'
                ),
                'http://example.com',
            ),
            array(
                array(
                    'scheme' => 'http',
                    'host' => 'example.com',
                    'path' => '/test',
                ),
                'http://example.com/test',
            ),
            array(
                array(
                    'scheme' => 'http',
                    'user' => 'user',
                    'host' => 'example.com',
                ),
                'http://user@example.com',
            ),
            array(
                array(
                    'scheme' => 'http',
                    'user' => 'user',
                    'pass' => 'pass',
                    'host' => 'example.com',
                ),
                'http://user:pass@example.com',
            ),
            array(
                array(
                    'scheme' => 'https',
                    'host' => 'www.example.com',
                    'path' => '/foo',
                    'query' => 'bar=10',
                    'fragment' => 'test',
                ),
                'https://www.example.com/foo?bar=10#test',
            ),
        );
    }

    /**
     * @dataProvider dataBuildUrl
     * @covers CL\Carpo\Assert\URL::buildUrl
     */
    public function testBuildUrl($url, $expected)
    {
        $this->assertSame($expected, URL::buildUrl($url));
    }

    public function dataConvertUtfUrl()
    {
        return array(
            array(
                'http://example.com',
                'http://example.com'
            ),
            array(
                'http://example.com?да=тест',
                'http://example.com?%D0%B4%D0%B0=%D1%82%D0%B5%D1%81%D1%82'
            ),
            array(
                'http://яндекс.рф',
                'http://xn--d1acpjx3f.xn--p1ai'
            ),
            array(
                'http://foo.com/unicode_(✪)_in_parens',
                'http://foo.com/unicode_%28%E2%9C%AA%29_in_parens'
            ),
            array(
                'https://www.example.com/foo/?bar=baz&inga=42&quux#example',
                'https://www.example.com/foo/?bar=baz&inga=42&quux=#example'
            ),
        );
    }

    /**
     * @dataProvider dataConvertUtfUrl
     * @covers CL\Carpo\Assert\URL::convertUtfUrl
     */
    public function testConvertUtfUrl($url, $expected)
    {
        $this->assertSame($expected, URL::convertUtfUrl($url));
    }

    public function dataIsValid()
    {
        return array(
            array('http://example.com', true),
            array('http://www.example.com/test.html', true),
            array('http://яндекс.рф', true),
            array('https://www.example.com/test.html', true),
            array('bitcoin://www.example.com/test.html', true),
            array('chrome://history', true),
            array('http://user:pass@www.example.com', true),
            array('http://user:@pass@www.example.com', true),
            array('http://userid:password@example.com/', true),
            array('http://user:pa:ss@www.example.com', true),
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
            array('http://foo.bar?q=Should allow spaces in query', true),
            array('http://">bla</a><script>alert(\'XSS\');</script>', false),
            array('//', false),
            array('http://#', false),
            array('http:///', false),
            array('http://'.str_pad('example-', 70, 'a').'.com', false),
            array(':// should fail', false),
            array('http://.www.foo.bar/', false),
            array('http://.www.foo.bar./', false),
        );
    }

    /**
     * @dataProvider dataIsValid
     * @covers CL\Carpo\Assert\URL::isValid
     */
    public function testIsValid($url, $expected)
    {
        $this->assertSame($expected, URL::isValid($url));
    }

    public function dataExecute()
    {
        return array(
            array('http://example.com', null, true),
            array('http://user:pass@www.example.com', null, true),
            array('example', null, 'test should be a valid URL address'),
            array('http://foo.com/unicode_(✪)_in_parens', null, true),
            array('http://foo.com/unicode_(✪)_in_parens', URL::STRICT, 'test should be a valid URL address'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\URL::execute
     */
    public function testExecute($value, $type, $expected)
    {
        $assertion = new URL('test', $type);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\URL::__construct
     * @covers CL\Carpo\Assert\URL::isStrict
     */
    public function testConstruct()
    {
        $assertion = new URL('test', URL::STRICT, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertTrue($assertion->isStrict());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
