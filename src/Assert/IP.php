<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * Assert that the value's is a valid IP address uses filter_var() internally
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class IP extends AbstractAssertion
{
    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject)) {
            $flags = FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE;

            if (! filter_var($this->getProperty($subject), FILTER_VALIDATE_IP, $flags)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
