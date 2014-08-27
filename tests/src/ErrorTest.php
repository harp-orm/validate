<?php

namespace Harp\Validate\Test;

use Harp\Validate\Error;
use Harp\Validate\Assert\LengthBetween;
use Harp\Validate\Assert\Present;
use stdClass;

/**
 * @group   error
 * @coversDefaultClass Harp\Validate\Error
 */
class ErrorTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getMessage
     * @covers ::getAssert
     * @covers ::__toString
     */
    public function testConstruct()
    {
        $assert = new LengthBetween('test', 10, 20, ':name is error somewhere between :length and :maxLength');
        $error = new Error($assert);

        $this->assertEquals('test', $error->getName());
        $this->assertSame($assert, $error->getAssert());
        $this->assertEquals('test is error somewhere between 10 and 20', $error->getMessage());
        $this->assertEquals('test is error somewhere between 10 and 20', (string) $error);
    }
}
