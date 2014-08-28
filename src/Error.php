<?php

namespace Harp\Validate;

use Harp\Validate\Assert\AbstractAssertion;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Error
{
    /**
     * The assertion this is an error of
     *
     * @var AbstractAssertion
     */
    private $assert;

    /**
     * @param AbstractAssertion $assert
     */
    public function __construct(AbstractAssertion $assert)
    {
        $this->assert = $assert;
    }

    /**
     * @return AbstractAssertion
     */
    public function getAssert()
    {
        return $this->assert;
    }

    /**
     * The name of the property this error was recorded for
     *
     * @return string
     */
    public function getName()
    {
        return $this->assert->getName();
    }

    /**
     * Get the error message
     *
     * @return string
     */
    public function getMessage()
    {
        return strtr($this->assert->getMessage(), $this->assert->getMessageParameters());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getMessage();
    }
}
