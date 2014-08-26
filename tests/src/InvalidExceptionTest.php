<?php

namespace Harp\Validate\Test;

use Harp\Validate\InvalidException;
use Exception;

/**
 * @coversDefaultClass Harp\Validate\InvalidException
 */
class InvalidExceptionTest extends AbstractTestCase
{
    /**
     * @covers ::setSubject
     * @covers ::getSubject
     */
    public function testSubject()
    {
        $previous = new Exception();
        $model = new Model();

        $exception = new InvalidException('message', 123, $previous);
        $exception->setSubject($model);

        $this->assertSame($previous, $exception->getPrevious());
        $this->assertSame(123, $exception->getCode());
        $this->assertSame($model, $exception->getSubject());
    }
}
