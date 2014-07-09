<?php

namespace Harp\Validate\Test;

use Harp\Validate\Error;

/**
 * @group   asserts
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

        $this->assertEquals(new Error(':name must be present', 'test'), $errors->getFirst());
    }
}
