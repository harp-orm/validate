<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\Matches;
use Harp\Validate\Subject;
use stdClass;

/**
 * @group   assert.matches
 * @coversDefaultClass Harp\Validate\Assert\Matches
 */
class MatchesTest extends AbstractTestCase
{
    public function dataGetError()
    {
        return [
            [(object) ['temp' => 'test', 'temp2' => 'test'], 'temp', 'temp2', true],
            [(object) ['temp' => 'test', 'temp2' => 's'], 'temp', 'temp2', 'temp must match temp2'],
            [(object) ['temp' => 'test', 'temp2' => ''], 'temp', 'temp2', 'temp must match temp2'],
            [(object) [], 'temp', 'temp2', true],
        ];
    }

    /**
     * @dataProvider datagetError
     * @covers ::getError
     */
    public function testgetError($subject, $name, $matches, $expected)
    {
        $assertion = new Matches($name, $matches);

        $this->assertAssertion($expected, $assertion, $subject);
    }

    /**
     * @covers ::__construct
     * @covers ::getMatches
     * @covers ::getMessageParameters
     */
    public function testConstruct()
    {
        $assertion = new Matches('test', 'test2', 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('test2', $assertion->getMatches());
        $this->assertEquals([':name' => 'test', ':matches' => 'test2'], $assertion->getMessageParameters());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
