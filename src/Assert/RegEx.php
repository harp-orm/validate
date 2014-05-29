<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;

/**
 * Assert that the value matches a given regex. Passed directly to preg_match()
 *
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
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName())) {
            $value = $this->getProperty($subject, $this->getName());

            if (! preg_match($this->pattern, $value)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
