<?php

namespace AerialShip\LightSaml;

final class Helper
{
    const TIME_FORMAT = 'Y-m-d\TH:i:s\Z';


    /**
     * @param int $time
     * @return string
     */
    public static function time2string($time)
    {
        return gmdate('Y-m-d\TH:i:s\Z', $time);
    }

    /**
     * @param int|string|\DateTime $value
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getTimestampFromValue($value)
    {
        if (is_string($value)) {
            return Helper::parseSAMLTime($value);
        } else if ($value instanceof \DateTime) {
            return $value->getTimestamp();
        } else if (is_int($value)) {
            return $value;
        } else {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * @param string $time
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function parseSAMLTime($time)
    {
        $matches = array();
        if(preg_match('/^(\\d\\d\\d\\d)-(\\d\\d)-(\\d\\d)T(\\d\\d):(\\d\\d):(\\d\\d)(?:\\.\\d+)?Z$/D',
            $time, $matches) == 0) {
            throw new \InvalidArgumentException('Invalid SAML2 timestamp: ' . $time);
        }

        $year = intval($matches[1]);
        $month = intval($matches[2]);
        $day = intval($matches[3]);
        $hour = intval($matches[4]);
        $minute = intval($matches[5]);
        $second = intval($matches[6]);

        // Use gmmktime because the timestamp will always be given in UTC.
        $ts = gmmktime($hour, $minute, $second, $month, $day, $year);
        return $ts;
    }


    public static function getClassNameOnly($value)
    {
        if (is_object($value)) {
            $value = get_class($value);
        } else if (!is_string($value)) {
            throw new \InvalidArgumentException('Expected string or object');
        }
        if (($pos = strrpos($value, '\\')) !== false) {
            $value = substr($value, $pos+1);
        }
        return $value;
    }

    public static function doClassNameMatch($object, $class)
    {
        if (!is_string($class)) {
            throw new \InvalidArgumentException('class argument must be string');
        }
        $result = false;
        $class = ltrim($class, '\\');
        $itemClass = get_class($object);
        if ($itemClass == $class) {
            $result = true;
        } else {
            $itemClass = self::getClassNameOnly($itemClass);
            if ($itemClass == $class) {
                $result = true;
            }
        }
        return $result;
    }


    /**
     * @param int $length
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function generateRandomBytes($length)
    {
        $length = intval($length);
        if (!$length) {
            throw new \InvalidArgumentException();
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            return openssl_random_pseudo_bytes($length);
        }

        $data = '';
        for($i = 0; $i < $length; $i++) {
            $data .= chr(mt_rand(0, 255));
        }
        return $data;
    }

    /**
     * @param string $bytes
     * @return string
     */
    public static function stringToHex($bytes)
    {
        $result = '';
        $len = strlen($bytes);
        for($i = 0; $i < $len; $i++) {
            $result .= sprintf('%02x', ord($bytes[$i]));
        }
        return $result;
    }


    /**
     * @return string
     */
    public static function generateID()
    {
        return '_'.self::stringToHex(self::generateRandomBytes(21));
    }

}