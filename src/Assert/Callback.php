<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;
use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Callback extends AbstractAssertion
{
    protected $callback;
    protected $message = '%s is invalid';

    public function __construct($name, $callback, $message = null)
    {
        if ( ! is_callable($callback))
        {
            throw new InvalidArgumentException('Callback should be callable');
        }

        $this->callback = $callback;

        parent::__construct($name, $message);
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function execute($object)
    {
        if ($this->issetProperty($object))
        {
            $value = $this->getProperty($object);

            if (! call_user_func($this->callback, $value))
            {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
