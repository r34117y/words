<?php

namespace App\Utils;

class StringHelper
{
    const VOWELS = ['a', 'ą', 'e', 'ę', 'y', 'i', 'o', 'ó', 'u'];
    const CONSONANTS = ['b', 'c', 'ć', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ł', 'm', 'n', 'ń', 'p', 'q', 'r', 's', 'ś', 't', 'v', 'w', 'x', 'z', 'ź', 'ż'];


    public static function startsWith(string $haystack, string $needle) : bool
    {
        return $haystack === "" || strrpos($haystack, $needle, -mb_strlen($needle)) !== false;
    }

    public static function endsWith(string $haystack, string $needle) : bool
    {
        $length = mb_strlen($needle);

        return $length === 0 ||(mb_substr($haystack, -$length) === $needle);
    }

    public static function stringToArray(string $string, bool $trim = true) : array
    {
        if ($trim) {
            $string = trim($string);
        }

        return preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
    }

    public static function sortString(string $string, $locale = 'pl_PL') : string
    {
        $array = self::stringToArray($string);
        sort($array, SORT_LOCALE_STRING);
        return implode('', $array);
    }

    public static function getSortedVowels(string $string)
    {
        $array = self::stringToArray($string);
        $new = [];
        for ($i = 0; $i < count($array); $i++) {
            if (in_array(strtolower($array[$i]), self::VOWELS)) {
                $new[] = $array[$i];
            }
        }
        sort($new, SORT_LOCALE_STRING);
        return implode('', $new);
    }

    public static function getSortedConsonants(string $string)
    {
        $array = self::stringToArray($string);
        $new = [];
        for ($i = 0; $i < count($array); $i++) {
            if (in_array(strtolower($array[$i]), self::CONSONANTS)) {
                $new[] = $array[$i];
            }
        }
        sort($new, SORT_LOCALE_STRING);
        return implode('', $new);
    }

    public static function getVowelsPattern(string $string)
    {
        $array = self::stringToArray($string);
        $pattern = '';
        for ($i = 0; $i < count($array); $i++) {
            if (in_array(strtolower($array[$i]), self::CONSONANTS)) {
                $pattern .= '_';
            } else if (in_array(strtolower($array[$i]), self::VOWELS)) {
                $pattern .= $array[$i];
            }
        }

        return $pattern;
    }

    public static function getConsonantsPattern(string $string)
    {
        $array = self::stringToArray($string);
        $pattern = '';
        for ($i = 0; $i < count($array); $i++) {
            if (in_array(strtolower($array[$i]), self::VOWELS)) {
                $pattern .= '_';
            } else if (in_array(strtolower($array[$i]), self::CONSONANTS)) {
                $pattern .= $array[$i];
            }
        }

        return $pattern;
    }
}
