<?php

namespace CL\Carpo;

use Countable;
use Iterator;
use SplObjectStorage;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Errors implements Iterator, Countable
{
    protected $errors;
    protected $subject;

    public function __construct($subject, array $errors = array())
    {
        $this->subject = $subject;
        $this->errors = new SplObjectStorage();

        $this->set($errors);
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return Error
     */
    public function current()
    {
        return $this->errors->current();
    }

    /**
     * @return integer
     */
    public function key()
    {
        return $this->errors->key();
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->errors->next();
    }

    /**
     * @return void
     */
    public function rewind()
    {
        return $this->errors->rewind();
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return $this->errors->valid();
    }

    /**
     * @param Error $error
     */
    public function add(Error $error)
    {
        $this->errors->attach($error);
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return count($this->errors) === 0;
    }

    /**
     * @param array $errors
     */
    public function set(array $errors)
    {
        array_walk($errors, array($this, 'add'));

        return $this;
    }

    /**
     * @param  Error $error
     * @return boolean
     */
    public function contains(Error $error)
    {
        return $this->errors->contains($error);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return $this->errors->count();
    }

    /**
     * @return SplObjectStorage
     */
    public function all()
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function humanize()
    {
        $result = array();

        foreach ($this->errors as $error)
        {
            $result []= $error->getFullMessage();
        }

        return implode(', ', $result);
    }

    public function __toString()
    {
        return $this->humanize();
    }
}
