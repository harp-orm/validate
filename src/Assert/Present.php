<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * Will trigger an error if the value is empty
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Present extends AbstractAssertion
{
    /**
     * @param string $name
     * @param string $message
     */
    public function __construct($name, $message = ':name must be present')
    {
        parent::__construct($name, $message);
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($object)
    {
        if (! $this->issetProperty($object)) {
            return new Error($this->getMessage(), $this->getName());
        }
    }
}
