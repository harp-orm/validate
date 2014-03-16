<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Present extends AbstractAssertion
{
    protected $message = '%s must be present';

    public function execute($object)
    {
        if ( ! $this->issetProperty($object)) {
            return new Error($this->getMessage(), $this->getName());
        }
    }
}
