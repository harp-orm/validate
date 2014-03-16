<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;
use InvalidArgumentException;

/**
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
     * @param mixed $callback
     * @param string $message
     */
    public function __construct($name, $callback, $message = null)
    {
        if ( ! is_callable($callback)) {
            throw new InvalidArgumentException('Callback should be callable');
        }

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
        if ($this->issetProperty($subject)) {
            $value = $this->getProperty($subject);

            if (! call_user_func($this->callback, $value)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
