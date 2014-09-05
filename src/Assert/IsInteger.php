<?php

namespace Harp\Validate\Assert;

/**
 * Assert that the value is a integer.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class IsInteger extends AbstractValueAssertion
{
    /**
     * @param strubg  $name
     * @param string  $message
     */
    public function __construct($name, $message = ':name should be a valid number')
    {
        parent::__construct($name, $message);
    }

    /**
     * @param  mixed   $value
     * @return boolean
     */
    public function isValid($value)
    {
        return (is_integer($value) or ctype_digit($value));
    }
}
