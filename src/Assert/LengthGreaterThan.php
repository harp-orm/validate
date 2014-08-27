<?php

namespace Harp\Validate\Assert;

/**
 * Assert that the value's string length is longer than a set length. Uses mb_strlen() internally.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class LengthGreaterThan extends AbstractLengthAssertion
{
    /**
     * @param string  $name
     * @param integer $length
     * @param string  $message
     */
    public function __construct($name, $length, $message = ':name should be more than :length letters')
    {
        parent::__construct($name, $length, $message);
    }

    /**
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        return self::getValueLength($value) > $this->getLength();
    }
}
