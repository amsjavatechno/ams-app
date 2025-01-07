<?php

namespace AmsApp\Utils;

class StringUtils {
    const BLANK = "";

    // Checks if a string is not null or empty
    public static function isEmpty($str) {
        return !isset($str) || $str === '';
    }

    // Checks if a string is not null or contains only whitespace
    public static function isBlank($str) {
        return !isset($str) || trim($str) === '';
    }

    // Trims leading and trailing whitespace from a string
    public static function trim($str) {
        return is_string($str) ? trim($str) : '';
    }

    // Checks if two strings are equal, null-safe
    public static function equals($str1, $str2) {
        return $str1 === $str2;
    }

    // Compares two strings in a null-safe manner
    public static function compare($str1, $str2) {
        if ($str1 === $str2) {
            return 0;
        }
        if ($str1 < $str2) {
            return -1;
        }
        return 1;
    }

    // Checks if a string starts with a given prefix, null-safe
    public static function startsWith($str, $prefix) {
        return isset($str) && isset($prefix) && strpos($str, $prefix) === 0;
    }

    // Checks if a string ends with a given suffix, null-safe
    public static function endsWith($str, $suffix) {
        return isset($str) && isset($suffix) && substr($str, -strlen($suffix)) === $suffix;
    }

    // Finds the index of the first occurrence of a substring
    public static function indexOf($str, $search) {
        return isset($str) ? strpos($str, $search) : -1;
    }

    // Finds the index of the last occurrence of a substring
    public static function lastIndexOf($str, $search) {
        return isset($str) ? strrpos($str, $search) : -1;
    }

    // Checks if a substring exists in a string
    public static function contains($str, $search) {
        return isset($str) && strpos($str, $search) !== false;
    }

    // Finds the index of the first occurrence of any of a set of strings
    public static function indexOfAny($str, $searchArray) {
        foreach ($searchArray as $search) {
            $pos = strpos($str, $search);
            if ($pos !== false) {
                return $pos;
            }
        }
        return -1;
    }

    // Finds the index of the last occurrence of any of a set of strings
    public static function lastIndexOfAny($str, $searchArray) {
        foreach (array_reverse($searchArray) as $search) {
            $pos = strrpos($str, $search);
            if ($pos !== false) {
                return $pos;
            }
        }
        return -1;
    }

    // Checks if a string contains only specific characters
    public static function containsOnly($str, $allowedChars) {
        return !preg_match('/[^' . preg_quote($allowedChars, '/') . ']/', $str);
    }

    // Checks if a string contains none of the given characters
    public static function containsNone($str, $disallowedChars) {
        return !preg_match('/[' . preg_quote($disallowedChars, '/') . ']/', $str);
    }

    // Checks if a string contains any of the given characters
    public static function containsAny($str, $anyChars) {
        return preg_match('/[' . preg_quote($anyChars, '/') . ']/', $str);
    }

    // Extracts a substring from the start (null-safe)
    public static function substring($str, $start, $length = null) {
        return isset($str) ? substr($str, $start, $length) : '';
    }

    // Extracts the left part of the string (null-safe)
    public static function left($str, $length) {
        return isset($str) ? substr($str, 0, $length) : '';
    }

    // Extracts the right part of the string (null-safe)
    public static function right($str, $length) {
        return isset($str) ? substr($str, -$length) : '';
    }

    // Extracts a substring from the middle (null-safe)
    public static function mid($str, $start, $length = null) {
        return isset($str) ? substr($str, $start, $length) : '';
    }

    // Extracts substring before a given string
    public static function substringBefore($str, $search) {
        $pos = strpos($str, $search);
        return $pos === false ? $str : substr($str, 0, $pos);
    }

    // Extracts substring after a given string
    public static function substringAfter($str, $search) {
        $pos = strpos($str, $search);
        return $pos === false ? '' : substr($str, $pos + strlen($search));
    }

    // Extracts substring between two strings
    public static function substringBetween($str, $open, $close) {
        $start = strpos($str, $open);
        if ($start === false) {
            return '';
        }
        $end = strpos($str, $close, $start + strlen($open));
        if ($end === false) {
            return '';
        }
        return substr($str, $start + strlen($open), $end - ($start + strlen($open)));
    }

    // Splits a string into an array based on a delimiter
    public static function split($str, $delimiter) {
        return explode($delimiter, $str);
    }

    // Joins an array of strings into a single string with a delimiter
    public static function join($array, $delimiter) {
        return implode($delimiter, $array);
    }

    // Removes a substring from a string
    public static function remove($str, $removeStr) {
        return str_replace($removeStr, '', $str);
    }

    // Replaces part of a string with another string
    public static function replace($str, $search, $replace) {
        return str_replace($search, $replace, $str);
    }

    // Removes the last character from a string
    public static function chop($str) {
        return rtrim($str, $str[strlen($str)-1]);
    }

    // Appends a suffix if it is not already present
    public static function appendIfMissing($str, $suffix) {
        return !self::endsWith($str, $suffix) ? $str . $suffix : $str;
    }

    // Prepends a prefix if it is not already present
    public static function prependIfMissing($str, $prefix) {
        return !self::startsWith($str, $prefix) ? $prefix . $str : $str;
    }

    // Left-pads a string
    public static function leftPad($str, $length, $padStr = ' ') {
        return str_pad($str, $length, $padStr, STR_PAD_LEFT);
    }

    // Right-pads a string
    public static function rightPad($str, $length, $padStr = ' ') {
        return str_pad($str, $length, $padStr, STR_PAD_RIGHT);
    }

    // Centers a string
    public static function center($str, $length, $padStr = ' ') {
        return str_pad($str, $length, $padStr, STR_PAD_BOTH);
    }

    // Repeats a string a given number of times
    public static function repeat($str, $times) {
        return str_repeat($str, $times);
    }

    // Converts a string to uppercase
    public static function upperCase($str) {
        return strtoupper($str);
    }

    // Converts a string to lowercase
    public static function lowerCase($str) {
        return strtolower($str);
    }

    // Swaps case of a string
    public static function swapCase($str) {
        return preg_replace_callback('/[a-zA-Z]/', function($matches) {
            return ctype_lower($matches[0]) ? strtoupper($matches[0]) : strtolower($matches[0]);
        }, $str);
    }

    // Capitalizes the first letter of each word
    public static function capitalize($str) {
        return ucwords(strtolower($str));
    }

    // Uncapitalizes the first letter of the string
    public static function uncapitalize($str) {
        return lcfirst($str);
    }

    // Counts occurrences of a substring in a string
    public static function countMatches($str, $search) {
        return substr_count($str, $search);
    }

    // Checks if a string contains only alphabetic characters
    public static function isAlpha($str) {
        return ctype_alpha($str);
    }

    // Checks if a string contains only numeric characters
    public static function isNumeric($str) {
        return is_numeric($str);
    }

    // Checks if a string contains only whitespace characters
    public static function isWhitespace($str) {
        return ctype_space($str);
    }

    // Checks if a string contains only printable ASCII characters
    public static function isAsciiPrintable($str) {
        return preg_match('/^[\x20-\x7E]*$/', $str);
    }

    // Returns a default string if the input is null
    public static function defaultString($str, $default) {
        return isset($str) && $str !== '' ? $str : $default;
    }

    // Rotates a string (circular shift)
    public static function rotate($str, $shift) {
        $length = strlen($str);
        $shift = $shift % $length; // Handle shifts greater than string length
        return substr($str, $shift) . substr($str, 0, $shift);
    }

    // Reverses a string
    public static function reverse($str) {
        return strrev($str);
    }

    // Reverses a string with a delimiter
    public static function reverseDelimited($str, $delimiter) {
        $parts = explode($delimiter, $str);
        $reversedParts = array_reverse($parts);
        return implode($delimiter, $reversedParts);
    }

    // Abbreviates a string using ellipses or another given string
    public static function abbreviate($str, $maxLength = 20, $ellipsis = '...') {
        return strlen($str) > $maxLength ? substr($str, 0, $maxLength) . $ellipsis : $str;
    }

    // Compares two strings and returns the differences
    public static function difference($str1, $str2) {
        $diff = '';
        for ($i = 0; $i < min(strlen($str1), strlen($str2)); $i++) {
            if ($str1[$i] !== $str2[$i]) {
                $diff .= $str1[$i] . '|' . $str2[$i] . ', ';
            }
        }
        return rtrim($diff, ', ');
    }

    // Calculates the Levenshtein distance (edit distance) between two strings
    public static function levenshteinDistance($str1, $str2) {
        return levenshtein($str1, $str2);
    }
}
