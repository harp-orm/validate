<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;
use Closure;

/**
 * Assert that the result of a given callback is true. You can thus use php's native validation functions.
 * It only passes the value to the method.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Callback extends AbstractAssertion
{
    /**
     * @var Closure
     */
    private $callback;

    /**
     * @param string  $name
     * @param Closure $callback
     * @param string  $message
     */
    public function __construct($name, Closure $callback, $message = ':name is invalid')
    {
        $this->callback = $callback;

        parent::__construct($name, $message);
    }

    /**
     * @return Closure
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param  object $subject
     * @return Error|null
     */
    public function getError($subject)
    {
        if (isset($subject->{$this->getName()})) {
            $value = $subject->{$this->getName()};
            $callback = $this->callback;

            if (! $callback($subject, $value)) {
                return new Error($this);
            }
        }
    }
}
