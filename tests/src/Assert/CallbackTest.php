<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\Callback;

/**
 * @group   assert.callback
 * @coversDefaultClass Harp\Validate\Assert\Callback
 */
class CallbackTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return [
            ['10', function ($subject) {return $subject->test === '10';}, true],
            ['black', function ($subject, $value) {return $value === 'black';}, true],
            ['black', function () {return true;}, true],
            ['black', function () {return false;}, 'test is invalid'],
        ];
    }

    /**
     * @dataProvider dataExecute
     * @covers ::execute
     */
    public function testExecute($value, $callback, $expected)
    {
        $assertion = new Callback('test', $callback);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getCallback
     */
    public function testConstruct()
    {
        $closure = function ($subject) {return $subject['test'] === '10';};
        $assertion = new Callback('test', $closure, 'custom message');

        $this->assertEquals($closure, $assertion->getCallback());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
