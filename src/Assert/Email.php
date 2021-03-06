<?php

namespace Harp\Validate\Assert;

/**
 * Assert if the value is not a proper email address.
 * By default it uses Email::NORMAL - a small and fast regex which should handle most cases.
 * If you need to validate unusual email addresses you can use Email::STRICT.
 * It will then use a slower but more comprehensive check.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Email extends AbstractValueAssertion
{
    public function __construct($name, $message = ':name should be a valid email')
    {
        parent::__construct($name, $message);
    }

    /**
     * @param  mixed   $value
     * @return boolean
     */
    public function isValid($value)
    {
        $expression =
            '/^

            [-_a-z0-9\'+*$^&%=~!?{}]++
            (?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+

            # domain part
            @

            # host name
            (?:(?![-.])[-a-z0-9.]+(?<![-.])

            # top level
            \.

            [a-z]{2,6}
            | # or
            \d{1,3}

            (?:\.\d{1,3}){3})

            $/iDx';

        return (bool) preg_match($expression, $value);
    }
}
