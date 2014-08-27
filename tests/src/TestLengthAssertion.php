<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\AbstractLengthAssertion;

/**
 * Test assertion
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class TestLengthAssertion extends AbstractLengthAssertion
{
    public function isValid($subject)
    {
        return $subject->get($this->getName()) === 'test';
    }
}
