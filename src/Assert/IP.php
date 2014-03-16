<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class IP extends AbstractAssertion
{
    protected $message = '%s should be a valid IP address';

    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $flags = FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE;

            if (! filter_var($this->getProperty($object), FILTER_VALIDATE_IP, $flags)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
