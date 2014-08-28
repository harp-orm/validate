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
     * @covers ::__construct
     * @covers ::getSubject
     * @covers ::getErrors
     */
    public function testSubject()
    {
        $previous = new Exception();
        $model = new Model();

        $this->assertFalse($model->validate());

        $exception = new InvalidException($model, $model->getErrors(), 123, $previous);

        $this->assertSame($previous, $exception->getPrevious());
        $this->assertSame(123, $exception->getCode());
        $this->assertSame($model, $exception->getSubject());

        $this->assertSame($model->getErrors(), $exception->getErrors());
    }
}
