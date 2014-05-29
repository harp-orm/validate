<?php

namespace Harp\Validate;

use InvalidArgumentException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Error
{
    protected static $translator = 'strtr';

    public static function getTranslator()
    {
        return self::$translator;
    }

    public static function setTranslator($translator)
    {
        if (! is_callable($translator)) {
            throw new InvalidArgumentException('Translator must be callable function');
        }

        self::$translator = $translator;
    }

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

    /**
     * @param string $message
     * @param string $name
     */
    public function __construct($message, $name, array $parameters = array())
    {
        $this->name = $name;
        $this->message = $message;
        $this->parameters = $parameters;
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
     * @param  string $name
     * @return Error  $this
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
        return array_merge(
            array(':name' => $this->name),
            $this->parameters
        );
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
        return call_user_func(self::$translator, $this->message, $this->getMessageParameters());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullMessage();
    }
}
