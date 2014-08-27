<?php

namespace Harp\Validate\Assert;

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
    private $name;

    /**
     * @var string
     */
    private $message;

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

    public function getMessageParameters()
    {
        return [
            ':name' => $this->getName(),
        ];
    }

    /**
     * @param  object $subject
     * @return \Harp\Validate\Error|null
     */
    abstract public function getError($subject);
}
