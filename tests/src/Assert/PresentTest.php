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
    public function dataIsValid()
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
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $expected)
    {
        $this->assertSame($expected, Present::isValid($value));
    }

    public function dataExecute()
    {
        return [
            ['something', true],
            [null, 'test must be present'],
            ['', 'test must be present'],
            [false, 'test must be present'],
            [0, true],
            ['0', true],
            [new stdClass(), true],
        ];
    }

    /**
     * @dataProvider dataExecute
     * @covers ::execute
     */
    public function testExecute($value, $expected)
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
