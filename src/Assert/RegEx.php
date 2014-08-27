<?php

namespace Harp\Validate\Assert;

/**
 * Assert that the value matches a given regex. Passed directly to preg_match()
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class RegEx extends AbstractValueAssertion
{
    private $pattern;

    /**
     * @param string $name
     * @param string $pattern regex string
     * @param string $message
     */
    public function __construct($name, $pattern, $message = ':name is invalid')
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
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        return preg_match($this->pattern, $value);
    }
}
