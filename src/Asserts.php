<?php

namespace CL\Carpo;

use CL\Carpo\Assert\AbstractAssertion;
use Countable;
use Iterator;
use SplObjectStorage;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Asserts implements Iterator, Countable
{
    protected $asserts;

    public function __construct(array $asserts = array())
    {
        $this->asserts = new SplObjectStorage();

        $this->set($asserts);
    }

    /**
     * @return AbstractAssertion
     */
    public function current()
    {
        return $this->asserts->current();
    }

    /**
     * @return integer
     */
    public function key()
    {
        return $this->asserts->key();
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->asserts->next();
    }

    /**
     * @return void
     */
    public function rewind()
    {
        return $this->asserts->rewind();
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return $this->asserts->valid();
    }

    /**
     * @param AbstractAssertion $assert
     */
    public function add(AbstractAssertion $assert)
    {
        $this->asserts->attach($assert);
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return count($this->asserts) === 0;
    }

    /**
     * @param array $asserts
     */
    public function set(array $asserts)
    {
        array_walk($asserts, array($this, 'add'));

        return $this;
    }

    /**
     * @param  AbstractAssertion $assert
     * @return boolean
     */
    public function contains(AbstractAssertion $assert)
    {
        return $this->asserts->contains($assert);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return $this->asserts->count();
    }

    /**
     * @return SplObjectStorage
     */
    public function all()
    {
        return $this->asserts;
    }

    /**
     * @param  object|array $subject
     * @return Errors        array of error objects
     */
    public function validate($subject)
    {
        $errors = new Errors($subject);

        foreach ($this->asserts as $assert) {
            if (($error = $assert->execute($subject))) {
                $errors->add($error);
            }
        }

        return $errors;
    }
}
