<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\Present;
use stdClass;

/**
 * @group   assert.present
 * @coversDefaultClass Harp\Validate\Assert\Present
 */
class PresentTest extends AbstractTestCase
{
    public function dataIsValue()
    {
        return [
            ['10', true],
            ['something', true],
            [new stdClass(), true],
            [[], true],
            [0, true],
            ['0', true],
            [false, false],
            [null, false],
            ['', false],
        ];
    }

    /**
     * @dataProvider dataIsValue
     * @covers ::isValue
     */
    public function testIsValue($value, $expected)
    {
        $this->assertSame($expected, Present::isValue($value));
    }

    public function dataGetError()
    {
        return [
            ['10', true],
            [0, true],
            ['0', true],
            [false, 'test must be present'],
            [null, 'test must be present'],
            ['', 'test must be present'],
        ];
    }

    /**
     * @dataProvider dataGetError
     * @covers ::getError
     */
    public function testGetError($value, $expected)
    {
        $assertion = new Present('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    public function testConstruct()
    {
        $assertion = new Present('test', 'custom message');
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
