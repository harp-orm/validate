<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;

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
     * @param  object|array $subject
     * @param  string       $name
     * @return boolean
     */
    public function issetProperty($subject, $name)
    {
        return is_array($subject) ? isset($subject[$name]) : isset($subject->{$name});
    }

    /**
     * @param  object|array $subject
     * @param  string       $name
     * @return mixed
     */
    public function getProperty($subject, $name)
    {
        return is_array($subject) ? $subject[$name] : $subject->{$name};
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    abstract public function execute($subject);
}
