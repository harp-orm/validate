<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\URLStrict;

/**
 * @group   assert.url
 * @coversDefaultClass Harp\Validate\Assert\URLStrict
 */
class URLStrictTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [

            // Strictly invalid
            ['http://яндекс.рф', 'test should be a valid URL address'],

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
            ['http://">bla</a><script>alert(\'XSS\');</script>', 'test should be a valid URL address'],
            ['//', 'test should be a valid URL address'],
            ['http://#', 'test should be a valid URL address'],
            ['http:///', 'test should be a valid URL address'],
            [':// should fail', 'test should be a valid URL address'],
            ['http://.www.foo.bar/', 'test should be a valid URL address'],
            ['http://.www.foo.bar./', 'test should be a valid URL address'],
            ['http://яндекс.ru/unicode_(✪)_in_parens', 'test should be a valid URL address'],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $expected)
    {
        $assertion = new URLStrict('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $assertion = new URLStrict('test', 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
