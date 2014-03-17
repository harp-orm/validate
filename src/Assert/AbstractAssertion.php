<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractAssertion
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $message;

    /**
     * @param string $name
     * @param string $message
     */
    public function __construct($name, $message = ':name is invalid')
    {
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param  object|string $subject
     * @return boolean
     */
    public function issetProperty($subject)
    {
        return is_array($subject) ? isset($subject[$this->name]) : isset($subject->{$this->name});
    }

    /**
     * @param  object|string $subject
     * @return mixed
     */
    public function getProperty($subject)
    {
        return is_array($subject) ? $subject[$this->name] : $subject->{$this->name};
    }

    /**
     * @param  object|string $subject
     * @return Error|null
     */
    abstract public function execute($subject);

}
