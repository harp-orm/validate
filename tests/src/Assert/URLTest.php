<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\URL;
use stdClass;

/**
 * @group   assert.url
 * @coversDefaultClass Harp\Validate\Assert\URL
 */
class URLTest extends AbstractTestCase
{
    public function dataBuildUrl()
    {
        return [
            [
                [
                    'scheme' => 'http',
                    'host' => 'example.com'
                ],
                'http://example.com',
            ],
            [
                [
                    'scheme' => 'http',
                    'host' => 'example.com',
                    'path' => '/test',
                ],
                'http://example.com/test',
            ],
            [
                [
                    'scheme' => 'http',
                    'user' => 'user',
                    'host' => 'example.com',
                ],
                'http://user@example.com',
            ],
            [
                [
                    'scheme' => 'http',
                    'user' => 'user',
                    'pass' => 'pass',
                    'host' => 'example.com',
                ],
                'http://user:pass@example.com',
            ],
            [
                [
                    'scheme' => 'https',
                    'host' => 'www.example.com',
                    'port' => '8882',
                    'path' => '/foo',
                    'query' => 'bar=10',
                    'fragment' => 'test',
                ],
                'https://www.example.com:8882/foo?bar=10#test',
            ],
        ];
    }

    /**
     * @dataProvider dataBuildUrl
     * @covers ::buildUrl
     */
    public function testBuildUrl($url, $expected)
    {
        $this->assertSame($expected, URL::buildUrl($url));
    }

    public function dataConvertUtfUrl()
    {
        return [
            [
                'http://example.com',
                'http://example.com'
            ],
            [
                'http://example.com?да=тест',
                'http://example.com?%D0%B4%D0%B0=%D1%82%D0%B5%D1%81%D1%82'
            ],
            [
                'http://яндекс.рф',
                'http://xn--d1acpjx3f.xn--p1ai'
            ],
            [
                'http://foo.com/unicode_(✪)_in_parens',
                'http://foo.com/unicode_%28%E2%9C%AA%29_in_parens'
            ],
            [
                'https://www.example.com/foo/?bar=baz&inga=42&quux#example',
                'https://www.example.com/foo/?bar=baz&inga=42&quux=#example'
            ],
        ];
    }

    /**
     * @dataProvider dataConvertUtfUrl
     * @covers ::convertUtfUrl
     */
    public function testConvertUtfUrl($url, $expected)
    {
        $this->assertSame($expected, URL::convertUtfUrl($url));
    }

    public function dataIsValidNormal()
    {
        return [
            ['http://example.com', true],
            ['http://www.example.com/test.html', true],
            ['http://яндекс.рф', true],
            ['https://www.example.com/test.html', true],
            ['bitcoin://www.example.com/test.html', true],
            ['chrome://history', true],
            ['http://user:pass@www.example.com', true],
            ['http://user:@pass@www.example.com', true],
            ['http://userid:password@example.com/', true],
            ['http://user:pa:ss@www.example.com', true],
            ['http://user@www.example.com', true],
            ['http://142.42.1.1:8080/', true],
            ['http://foo.com/blah_(wikipedia)#cite-1', true],
            ['http://www.example.com/wpstyle/?p=364', true],
            ['https://www.example.com/foo/?bar=baz&inga=42&quux', true],
            ['http://foo.bar/?q=Test%20URL-encoded%20stuff', true],
            ['http://foo.com/unicode_(✪)_in_parens', true],
            ['ftp://example-example.co.uk', true],
            ['ftp://90.190.32.12', true],
            ['ftp://90.190.32.12/test.html', true],
            ['http://'.str_pad('example-', 50, 'a').'.com', true],
            ['http://foo.bar?q=Should allow spaces in query', true],
            ['http://">bla</a><script>alert(\'XSS\');</script>', false],
            ['//', false],
            ['http://#', false],
            ['http:///', false],
            ['http://'.str_pad('example-', 70, 'a').'.com', false],
            [':// should fail', false],
            ['http://.www.foo.bar/', false],
            ['http://.www.foo.bar./', false],
        ];
    }

    /**
     * @dataProvider dataIsValidNormal
     * @covers ::isValidNormal
     */
    public function testIsValidNormal($url, $expected)
    {
        $this->assertSame($expected, URL::isValidNormal($url));
    }

    public function dataIsValidStrict()
    {
        return [

            // Strictly invalid
            ['http://яндекс.рф', false],

            // Strictly valid
            ['http://'.str_pad('example-', 70, 'a').'.com', true],
            ['http://example.com', true],
            ['http://www.example.com/test.html', true],
            ['https://www.example.com/test.html', true],
            ['bitcoin://www.example.com/test.html', true],
            ['chrome://history', true],
            ['http://user:pass@www.example.com', true],
            ['http://user:@pass@www.example.com', true],
            ['http://userid:password@example.com/', true],
            ['http://user:pa:ss@www.example.com', true],
            ['http://user@www.example.com', true],
            ['http://142.42.1.1:8080/', true],
            ['http://foo.com/blah_(wikipedia)#cite-1', true],
            ['http://www.example.com/wpstyle/?p=364', true],
            ['https://www.example.com/foo/?bar=baz&inga=42&quux', true],
            ['http://foo.bar/?q=Test%20URL-encoded%20stuff', true],
            ['ftp://example-example.co.uk', true],
            ['ftp://90.190.32.12', true],
            ['ftp://90.190.32.12/test.html', true],
            ['http://'.str_pad('example-', 50, 'a').'.com', true],
            ['http://">bla</a><script>alert(\'XSS\');</script>', false],
            ['//', false],
            ['http://#', false],
            ['http:///', false],
            [':// should fail', false],
            ['http://.www.foo.bar/', false],
            ['http://.www.foo.bar./', false],
        ];
    }

    /**
     * @dataProvider dataIsValidStrict
     * @covers ::isValidStrict
     */
    public function testIsValidStrict($url, $expected)
    {
        $this->assertSame($expected, URL::isValidStrict($url));
    }

    public function dataIsValid()
    {
        return [
            ['http://example.com', URL::NORMAL, true],
            ['http://user:pass@www.example.com', URL::NORMAL, true],
            ['example', URL::NORMAL, 'test should be a valid URL address'],
            ['http://foo.com/unicode_(✪)_in_parens', URL::NORMAL, true],
            ['http://user:pass@www.example.com', URL::STRICT, true],
            ['http://example.com', URL::STRICT, true],
            ['http://яндекс.ru/unicode_(✪)_in_parens', URL::STRICT, 'test should be a valid URL address'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $type, $expected)
    {
        $assertion = new URL('test', $type);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::isStrict
     */
    public function testConstruct()
    {
        $assertion = new URL('test', URL::STRICT, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertTrue($assertion->isStrict());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
