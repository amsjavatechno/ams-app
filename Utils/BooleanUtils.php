<?php

namespace AmsApp\Utils;

class BooleanUtils {

    // Performs an 'and' operation on a set of booleans
    public static function and(...$array) {
        foreach ($array as $bool) {
            if (!$bool) {
                return false;
            }
        }
        return true;
    }

    // Performs an 'and' operation on an array of Booleans
    public static function andArray(...$array) {
        foreach ($array as $bool) {
            if ($bool === null || !$bool) {
                return false;
            }
        }
        return true;
    }

    // Returns an array of possible boolean values
    public static function booleanValues() {
        return [false, true];
    }

    // Compares two boolean values
    public static function compare($x, $y) {
        if ($x === $y) {
            return 0;
        }
        return $x ? 1 : -1;
    }

    // Performs the given action for each boolean value
    public static function forEach(callable $action) {
        foreach (self::booleanValues() as $value) {
            $action($value);
        }
    }

    // Checks if a Boolean value is false, handling null by returning false
    public static function isFalse($bool) {
        return $bool === null ? false : !$bool;
    }

    // Checks if a Boolean value is not false, handling null by returning true
    public static function isNotFalse($bool) {
        return $bool === null ? true : $bool !== false;
    }

    // Checks if a Boolean value is not true, handling null by returning true
    public static function isNotTrue($bool) {
        return $bool === null ? true : $bool !== true;
    }

    // Checks if a Boolean value is true, handling null by returning false
    public static function isTrue($bool) {
        return $bool === null ? false : $bool === true;
    }

    // Negates the specified boolean
    public static function negate($bool) {
        return !$bool;
    }

    // Performs a one-hot operation on an array of booleans
    public static function oneHot(...$array) {
        $count = 0;
        foreach ($array as $bool) {
            if ($bool) {
                $count++;
            }
        }
        return $count === 1;
    }

    // Performs a one-hot operation on an array of Booleans
    public static function oneHotArray(...$array) {
        return self::oneHot(...$array);
    }

    // Performs an 'or' operation on a set of booleans
    public static function or(...$array) {
        foreach ($array as $bool) {
            if ($bool) {
                return true;
            }
        }
        return false;
    }

    // Performs an 'or' operation on an array of Booleans
    public static function orArray(...$array) {
        foreach ($array as $bool) {
            if ($bool === true) {
                return true;
            }
        }
        return false;
    }

    // Returns an array of possible primitive boolean values (false, true)
    public static function primitiveValues() {
        return [false, true];
    }

    // Converts an int to a boolean (zero is false, everything else is true)
    public static function toBoolean($value) {
        return $value !== 0;
    }

    // Converts an int to a boolean specifying the conversion values
    public static function toBooleanWithValues($value, $trueValue, $falseValue) {
        return $value === $trueValue;
    }

    // Converts a Boolean to a boolean (null becomes false)
    public static function toBooleanFromBoolean($bool) {
        return $bool === null ? false : $bool;
    }

    // Converts an Integer to a boolean specifying the conversion values
    public static function toBooleanFromInteger($value, $trueValue, $falseValue) {
        return $value === $trueValue;
    }

    // Converts a String to a boolean (optimized for performance)
    public static function toBooleanFromString($str) {
        return strtolower($str) === 'true';
    }

    // Converts a String to a Boolean (throws exception if no match found)
    public static function toBooleanFromStringWithValues($str, $trueString, $falseString) {
        if (strtolower($str) === strtolower($trueString)) {
            return true;
        } elseif (strtolower($str) === strtolower($falseString)) {
            return false;
        }
        throw new InvalidArgumentException('String does not match any known boolean value');
    }

    // Converts a Boolean to a boolean, handling null by returning a default value
    public static function toBooleanDefaultIfNull($bool, $valueIfNull) {
        return $bool === null ? $valueIfNull : $bool;
    }

    // Converts an int to a Boolean (zero is false, everything else is true)
    public static function toBooleanObject($value) {
        return $value === 0 ? false : true;
    }

    // Converts an Integer to a Boolean using the convention that zero is false
    public static function toBooleanObjectFromInteger($value) {
        return $value === 0 ? false : true;
    }

    // Converts a Boolean to an Integer using the convention that true is 1 and false is 0
    public static function toInteger($bool) {
        return $bool ? 1 : 0;
    }

    // Converts a boolean to an int specifying the conversion values
    public static function toIntegerWithValues($bool, $trueValue, $falseValue) {
        return $bool ? $trueValue : $falseValue;
    }

    // Converts a Boolean to an Integer specifying the conversion values
    public static function toIntegerFromBoolean($bool, $trueValue, $falseValue, $nullValue) {
        if ($bool === null) {
            return $nullValue;
        }
        return $bool ? $trueValue : $falseValue;
    }

    // Converts a boolean to a String returning one of the input Strings
    public static function toString($bool, $trueString, $falseString) {
        return $bool ? $trueString : $falseString;
    }

    // Converts a Boolean to a String returning one of the input Strings
    public static function toStringFromBoolean($bool, $trueString, $falseString, $nullString) {
        if ($bool === null) {
            return $nullString;
        }
        return $bool ? $trueString : $falseString;
    }

    // Converts a boolean to a String returning 'on' or 'off'
    public static function toStringOnOff($bool) {
        return $bool ? 'on' : 'off';
    }

    // Converts a Boolean to a String returning 'on', 'off', or null
    public static function toStringOnOffObject($bool) {
        return $bool === null ? null : ($bool ? 'on' : 'off');
    }

    // Converts a boolean to a String returning 'true' or 'false'
    public static function toStringTrueFalse($bool) {
        return $bool ? 'true' : 'false';
    }

    // Converts a Boolean to a String returning 'true', 'false', or null
    public static function toStringTrueFalseObject($bool) {
        return $bool === null ? null : ($bool ? 'true' : 'false');
    }

    // Converts a boolean to a String returning 'yes' or 'no'
    public static function toStringYesNo($bool) {
        return $bool ? 'yes' : 'no';
    }

    // Converts a Boolean to a String returning 'yes', 'no', or null
    public static function toStringYesNoObject($bool) {
        return $bool === null ? null : ($bool ? 'yes' : 'no');
    }

    // Returns an unmodifiable list of Booleans [false, true]
    public static function values() {
        return [false, true];
    }

    // Performs an XOR operation on a set of booleans
    public static function xor(...$array) {
        $result = false;
        foreach ($array as $bool) {
            $result = $result xor $bool;
        }
        return $result;
    }

    // Performs an XOR operation on an array of Booleans
    public static function xorArray(...$array) {
        return self::xor(...$array);
    }
}
