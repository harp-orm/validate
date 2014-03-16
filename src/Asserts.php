<?php

namespace CL\Carpo;

use CL\Carpo\Assert\AbstractAssertion;
use Countable;
use Iterator;
use SplObjectStorage;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Asserts implements Iterator, Countable
{
    protected $asserts;

    public function __construct(array $asserts = array())
    {
        $this->asserts = new SplObjectStorage();

        $this->set($asserts);
    }

    public function current()
    {
        return $this->asserts->current();
    }

    public function key()
    {
        return $this->asserts->key();
    }

    public function next()
    {
        return $this->asserts->next();
    }

    public function rewind()
    {
        return $this->asserts->rewind();
    }

    public function valid()
    {
        return $this->asserts->valid();
    }

    public function add(AbstractAssertion $assert)
    {
        $this->asserts->attach($assert);
    }

    public function isEmpty()
    {
        return empty($this->asserts);
    }

    public function set(array $asserts)
    {
        array_walk($asserts, array($this, 'add'));

        return $this;
    }

    public function contains(AbstractAssertion $assert)
    {
        return $this->asserts->contains($assert);
    }

    public function count()
    {
        return $this->asserts->count();
    }

    public function all()
    {
        return $this->asserts;
    }

    public function validate($subject)
    {
        $errors = array();

        foreach ($this->asserts as $assert) {
            if (($error = $assert->execute($subject))) {
                $errors []= $error;
            }
        }

        return $errors;
    }
}
