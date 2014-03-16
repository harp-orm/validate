<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class RegEx extends AbstractAssertion
{
    protected $pattern;

    /**
     * @param string $name
     * @param string $pattern regex string
     * @param string $message
     */
    public function __construct($name, $pattern, $message = null)
    {
        $this->pattern = (string) $pattern;

        parent::__construct($name, $message);
    }

    /**
     * RegEx string, passed to preg_match
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $value = $this->getProperty($object);

            if (! preg_match($this->pattern, $value)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
