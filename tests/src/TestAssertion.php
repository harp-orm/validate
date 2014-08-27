<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\AbstractAssertion;
use Harp\Validate\Error;

/**
 * Test assertion
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class TestAssertion extends AbstractAssertion
{
    public function getError($subject)
    {
        if (! isset($subject->{$this->getName()}) or $subject->{$this->getName()} !== 'test') {
            return new Error($this);
        }
    }
}
