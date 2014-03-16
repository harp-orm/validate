<?php

namespace CL\Carpo;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Error
{
    const DOMAIN = 'carpo';

    /**
     * The name of the property this error was recorded for
     *
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var string
     */
    protected $message;

    public function __construct($message, $name)
    {
        $params = func_get_args();

        $this->parameters = array_slice($params, 2);

        $this->name = $name;
        $this->message = $message;
    }

    /**
     * The name of the property this error was recorded for
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Change the name of the property for this error.
     *
     * @param string $name
     * @return Error $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * All the parameters for the message (replacing %s)
     *
     * @return array
     */
    public function getMessageParameters()
    {
        $parameters = array($this->name);

        if ($this->parameters) {
            $parameters = array_merge($parameters, $this->parameters);
        }

        return $parameters;
    }

    /**
     * Get the error message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the error message, with all placeholders filled
     *
     * @return string
     */
    public function getFullMessage()
    {
        return vsprintf($this->message, $this->getMessageParameters());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullMessage();
    }
}
