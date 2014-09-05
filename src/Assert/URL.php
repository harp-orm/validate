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
class URL extends AbstractValueAssertion
{
    /**
     * Build url from parts, opposite of parse_url
     *
     * @param  array  $parts return of parse_url function
     * @return string complete url
     */
    public static function buildUrl($parts)
    {
        $url = '';

        if (isset($parts['scheme'])) {
            $url .= $parts['scheme'].'://';
        }

        if (isset($parts['user'])) {
            if (isset($parts['pass'])) {
                $url .= $parts['user'].':'.$parts['pass'].'@';
            } else {
                $url .= $parts['user'].'@';
            }
        }

        if (isset($parts['host'])) {
            $url .= $parts['host'];
        }

        if (isset($parts['port'])) {
            $url .= ':'.$parts['port'];
        }

        if (isset($parts['path'])) {
            $url .= $parts['path'];
        }

        if (isset($parts['query'])) {
            $url .= '?'.$parts['query'];
        }

        if (isset($parts['fragment'])) {
            $url .= '#'.$parts['fragment'];
        }

        return $url;
    }

    /**
     * Convert utf parts of urls
     *
     * @param  string $url
     * @return string
     */
    public static function convertUtfUrl($url)
    {
        $parts = (array) parse_url($url);

        if (isset($parts['host'])) {
            if (function_exists('idn_to_ascii')) {
                $parts['host'] = idn_to_ascii($parts['host']);
            }
        }

        if (isset($parts['path'])) {
            $parts['path'] = implode('/', array_map('urlencode', explode('/', $parts['path'])));
        }

        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);

            $parts['query'] = http_build_query($query);
        }

        return self::buildUrl($parts);
    }

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
        $url = self::convertUtfUrl($value);

        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
