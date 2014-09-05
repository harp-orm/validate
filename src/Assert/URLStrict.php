<?php

namespace Harp\Validate\Assert;

/**
 * Assert if the value is a valid url.
 * By default it uses URL::NORMAL which converts all UTF related charecters in the url to their proper encoding.
 * It also will convert non-ASCII domain names, using "idn" if the "intl" extension is available.
 * This is similar to what browsers normally do.
 * If you want to use a more strict definition or URLs, stright from the RFC - you can use URL::STRICT.
 * It directly uses php's filter_var() method.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class URLStrict extends AbstractValueAssertion
{
    /**
     * @param strubg  $name
     * @param string  $message
     */
    public function __construct($name, $message = ':name should be a valid URL address')
    {
        parent::__construct($name, $message);
    }

    /**
     * @param  mixed   $value
     * @return boolean
     */
    public function isValid($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
}
