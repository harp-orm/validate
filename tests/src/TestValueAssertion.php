<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\AbstractValueAssertion;

/**
 * Test assertion
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class TestValueAssertion extends AbstractValueAssertion
{
    public function isValid($value)
    {
        return $value === 'test';
    }
}
