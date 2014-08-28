<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractValueAssertion extends AbstractAssertion
{
    /**
     * @param  object     $subject
     * @return Error|null
     */
    public function getError($subject)
    {
        if (isset($subject->{$this->getName()})) {
            $value = $subject->{$this->getName()};

            if (! $this->isValid($value)) {
                return new Error($this);
            }
        }
    }

    /**
     * @param  mixed   $value
     * @return boolean
     */
    abstract public function isValid($value);
}
