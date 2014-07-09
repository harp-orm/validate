<?php

namespace Harp\Validate\Test;

use Harp\Validate\ValidateTrait;
use Harp\Validate\Asserts;
use Harp\Validate\Assert\Present;

/**
 * @group   error
 * @coversDefaultClass Harp\Validate\Error
 */
class Model
{
    use ValidateTrait;

    public $test;

    public function getValidationAsserts()
    {
        return new Asserts(array(
            new Present('test'),
        ));
    }
}
