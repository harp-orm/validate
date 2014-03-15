<?php

namespace CL\Carpo;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Error {

    protected $parameters;

    protected $message;

    public function __construct($message)
    {
        $params = func_get_args();

        $this->parameters = array_slice($params, 1);

        $this->message = $message;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getMessage()
    {
        $message = dgettext('carpo', $this->message);

        return $this->parameters ? vsprintf($message, $this->parameters) : $message;
    }

    public function __toString()
    {
        return $this->getMessage();
    }
}
