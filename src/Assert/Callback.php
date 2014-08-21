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
     * @var mixed
     */
    protected $callback;

    /**
     * @param string $name
     * @param mixed  $callback
     * @param string $message
     */
    public function __construct($name, Closure $callback, $message = ':name is invalid')
    {
        $this->callback = $callback;

        parent::__construct($name, $message);
    }

    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName())) {
            $value = $this->getProperty($subject, $this->getName());

            $callback = $this->callback;

            if (! $callback($subject, $value)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
