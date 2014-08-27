<?php

namespace Harp\Validate\Test;

use Harp\Validate\Error;
use Harp\Validate\InvalidException;
use Harp\Validate\Assert\Present;

/**
 * @coversDefaultClass Harp\Validate\ValidateTrait
 */
class ValidateTraitTest extends AbstractTestCase
{
    /**
     * @covers ::getErrors
     * @covers ::isEmptyErrors
     * @covers ::validate
     */
    public function testTrait()
    {
        $model = new Model();

        $errors = $model->getErrors();

        $this->assertInstanceOf('Harp\Validate\Errors', $errors);
        $this->assertTrue($errors->isEmpty());
        $this->assertTrue($model->isEmptyErrors());

        $model->validate();

        $errors = $model->getErrors();

        $this->assertInstanceOf('Harp\Validate\Errors', $errors);
        $this->assertFalse($errors->isEmpty());
        $this->assertCount(1, $errors);
        $this->assertFalse($model->isEmptyErrors());

        $this->assertEquals(new Error(new Present('test')), $errors->getFirst());

        $this->setExpectedException('Harp\Validate\InvalidException', 'Has errors: test must be present');

        $model->assertValid();
    }

    /**
     * @covers ::assertValid
     */
    public function testAssertValid()
    {
        $model = new Model();

        $model->test = '!!!!';

        $model->assertValid();

        $model->test = null;

        try {
            $model->assertValid();
            $this->fail('Should Throw an exception');
        } catch (InvalidException $exception) {
            $this->assertEquals('Has errors: test must be present', $exception->getMessage());
            $this->assertSame($model, $exception->getSubject());
        }
    }
}
