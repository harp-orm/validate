<?php namespace CL\Carpo\Assert;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
abstract class AbstractAssertion
{
    protected $name;
    protected $message;

    public function __construct($name, $message = null)
    {
        $this->name = $name;

        if ($message !== null) {
            $this->message = $message;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function issetProperty($subject)
    {
        return is_array($subject) ? isset($subject[$this->name]) : isset($subject->{$this->name});
    }

    public function getProperty($subject)
    {
        return is_array($subject) ? $subject[$this->name] : $subject->{$this->name};
    }

    abstract public function execute($subject);

}
