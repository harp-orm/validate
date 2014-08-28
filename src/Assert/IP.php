<?php

namespace Harp\Validate\Assert;

/**
 * Assert that the value's is a valid IP address uses filter_var() internally
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class IP extends AbstractValueAssertion
{
    /**
     * @param  mixed   $value
     * @return boolean
     */
    public function isValid($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE);
    }
}
