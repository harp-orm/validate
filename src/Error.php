<?php

namespace CL\Carpo;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Error
{
    protected $name;
    protected $parameters;

    protected $message;

    public function __construct($message, $name)
    {
        $params = func_get_args();

        $this->parameters = array_slice($params, 2);

        $this->name = $name;
        $this->message = $message;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getMessageParameters()
    {
        $parameters = array($this->name);

        if ($this->parameters) {
            $parameters = array_merge($parameters, $this->parameters);
        }

        return $parameters;
    }

    public function getMessage()
    {
        $message = dgettext('carpo', $this->message);

        return vsprintf($message, $this->getMessageParameters());
    }

    public function __toString()
    {
        return $this->getMessage();
    }
}
