<?php

namespace SoapBox\Formatter\Parsers;

class XmlParser extends Parser
{
    private $xml;

    /**
     * Ported from laravel-formatter
     * https://github.com/SoapBox/laravel-formatter.
     *
     * @author  Daniel Berry <daniel@danielberry.me>
     * @license MIT License (see LICENSE.readme included in the bundle)
     */
    private function objectify($value)
    {
        $temp = is_string($value) ? simplexml_load_string($value, 'SimpleXMLElement', LIBXML_NOCDATA) : $value;

        $result = [];

        foreach ((array) $temp as $key => $value) {
            if (is_array($value)) {
                $result = $this->objectify($value);
            } elseif (is_object($value)) {
                $result[$key] = $this->objectify($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function __construct($data)
    {
        $this->xml = $this->objectify($data);
    }

    public function toArray()
    {
        return (array) $this->xml;
    }
}
