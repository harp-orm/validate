<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\LengthBetween;
use stdClass;

/**
 * @group   assert.length_between
 * @coversDefaultClass Harp\Validate\Assert\LengthBetween
 */
class LengthBetweenTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return [
            ['something', 4,  20, true],
            ['something', 10, 20, 'test should be between 10 and 20 letters'],
            ['something', 3, 5, 'test should be between 3 and 5 letters'],
            ['something', 9, 10, true],
            ['something', 7, 9, true],
            ['тест', 3,  10, true],
            ['тест', 10, 20, 'test should be between 10 and 20 letters'],
            ['тест', 2, 3, 'test should be between 2 and 3 letters'],
            ['тест', 4, 10, true],
            ['тест', 2, 4, true],
        ];
    }

    /**
     * @dataProvider dataExecute
     * @covers ::execute
     */
    public function testExecute($value, $min, $max, $expected)
    {
        $assertion = new LengthBetween('test', $min, $max);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getMin
     * @covers ::getMax
     */
    public function testConstruct()
    {
        $assertion = new LengthBetween('test', 4, 5, 'custom message');

        $this->assertEquals(4, $assertion->getMin());
        $this->assertEquals(5, $assertion->getMax());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());

        $this->setExpectedException('InvalidArgumentException');

        new LengthBetween('test', 4, 2);
    }
}
