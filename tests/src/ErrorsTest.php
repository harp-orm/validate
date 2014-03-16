<?php

namespace CL\Carpo\Test;

use CL\Carpo\Errors;
use CL\Carpo\Error;
use stdClass;

/**
 * @group   errors
 */
class ErrorsTest extends AbstractTestCase
{
    /**
     * @covers CL\Carpo\Errors::__construct
     * @covers CL\Carpo\Errors::all
     * @covers CL\Carpo\Errors::add
     * @covers CL\Carpo\Errors::set
     * @covers CL\Carpo\Errors::next
     * @covers CL\Carpo\Errors::current
     * @covers CL\Carpo\Errors::valid
     * @covers CL\Carpo\Errors::count
     * @covers CL\Carpo\Errors::key
     * @covers CL\Carpo\Errors::rewind
     * @covers CL\Carpo\Errors::contains
     * @covers CL\Carpo\Errors::isEmpty
     */
    public function testConstruct()
    {
        $subject = new stdClass();

        $errorObjects = array(
            new Error('test', 'test'),
            new Error('test', 'test'),
        );

        $errors = new Errors($subject, $errorObjects);

        $this->assertSame($subject, $errors->getSubject());
        $this->assertCount(2, $errors);

        foreach ($errors as $i => $error)
        {
            $this->assertSame($errorObjects[$i], $error);
            $this->assertTrue($errors->contains($error));
        }

        $errors->rewind();

        $this->assertFalse($errors->isEmpty());

        $all = $errors->all();

        $this->assertCount(2, $all);

        foreach ($all as $i => $error)
        {
            $this->assertSame($errorObjects[$i], $error);
            $this->assertTrue($all->contains($error));
        }
    }
}
