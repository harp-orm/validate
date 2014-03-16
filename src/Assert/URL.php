<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class URL extends AbstractAssertion
{
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

    public static function convertUtfUrl($url)
    {
        $parts = parse_url($url);

        if (extension_loaded('intl')) {
            if (isset($parts['host'])) {
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

    const STRICT = 1;

    protected $message = '%s should be a valid URL address';
    protected $type;

    public function __construct($name, $type = null, $message = null)
    {
        $this->type = $type;

        parent::__construct($name, $message);
    }

    public function isStrict()
    {
        return $this->type == self::STRICT;
    }

    public static function isValid($url)
    {
        $url = self::convertUtfUrl($url);

        return self::isValidStrict($url);
    }

    public static function isValidStrict($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $value = $this->getProperty($object);

            if (! ($this->isStrict() ? self::isValidStrict($value) : self::isValid($value))) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
