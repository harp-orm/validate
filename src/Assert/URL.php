<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;

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
class URL extends AbstractAssertion
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

    const NORMAL = 1;
    const STRICT = 2;

    /**
     * @var integer
     */
    protected $type;

    public function __construct($name, $type = URL::NORMAL, $message = ':name should be a valid URL address')
    {
        $this->type = $type;

        parent::__construct($name, $message);
    }

    /**
     * @return boolean
     */
    public function isStrict()
    {
        return $this->type == self::STRICT;
    }

    /**
     * Convert utf parts of url and then check if its valid
     *
     * @param  string  $url
     * @return boolean
     */
    public static function isValid($url)
    {
        $url = self::convertUtfUrl($url);

        return self::isValidStrict($url);
    }

    /**
     * Check url against the RFC directly, using php's built in filter_var
     *
     * @param  string  $url
     * @return boolean
     */
    public static function isValidStrict($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName())) {
            $value = $this->getProperty($subject, $this->getName());

            if (! ($this->isStrict() ? self::isValidStrict($value) : self::isValid($value))) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
