<?php
namespace AmsApp\Utils;
class NumberUtils {

    // Compares two byte values numerically
    public static function compareByte($x, $y): bool {
        return $x === $y;
    }

    // Compares two int values numerically
    public static function compareInt($x, $y): bool {
        return $x === $y;
    }

    // Compares two long values numerically
    public static function compareLong($x, $y): bool {
        return $x === $y;
    }

    // Compares two short values numerically
    public static function compareShort($x, $y): bool {
        return $x === $y;
    }

    // Creates a BigDecimal from a String
    public static function createBigDecimal($str) {
        return (new \NumberFormatter('en_US', \NumberFormatter::DECIMAL))->parse($str);
    }

    // Creates a BigInteger from a String
    public static function createBigInteger($str) {
        return gmp_init($str);
    }

    // Creates a Double from a String
    public static function createDouble($str): float {
        return (double)$str;
    }

    // Creates a Float from a String
    public static function createFloat($str): float {
        return (float)$str;
    }

    // Creates an Integer from a String
    public static function createInteger($str): int {
        return (int)$str;
    }

    // Creates a Long from a String
    public static function createLong($str): int {
        return (int)$str; // PHP doesn't have long type, so we use int
    }

    // Creates a Number from a String
    public static function createNumber($str) {
        return is_numeric($str) ? $str : null;
    }

    // Checks whether the String is a valid number
    public static function isCreatable($str): bool {
        return is_numeric($str);
    }

    // Checks whether the String contains only digit characters
    public static function isDigits($str): bool {
        return ctype_digit($str);
    }

    // Checks whether the String is a parsable number
    public static function isParsable($str): bool {
        return is_numeric($str);
    }

    // Returns the maximum value in an array of bytes
    public static function maxByte(...$array): int {
        return max($array);
    }

    // Gets the maximum of three byte values
    public static function maxByte3($a, $b, $c): int {
        return max($a, $b, $c);
    }

    // Returns the maximum value in an array of doubles
    public static function maxDouble(...$array): float {
        return max($array);
    }

    // Gets the maximum of three double values
    public static function maxDouble3($a, $b, $c): float {
        return max($a, $b, $c);
    }

    // Returns the maximum value in an array of floats
    public static function maxFloat(...$array): float {
        return max($array);
    }

    // Gets the maximum of three float values
    public static function maxFloat3($a, $b, $c): float {
        return max($a, $b, $c);
    }

    // Returns the maximum value in an array of ints
    public static function maxInt(...$array): int {
        return max($array);
    }

    // Gets the maximum of three int values
    public static function maxInt3($a, $b, $c): int {
        return max($a, $b, $c);
    }

    // Returns the maximum value in an array of longs
    public static function maxLong(...$array): int {
        return max($array);
    }

    // Gets the maximum of three long values
    public static function maxLong3($a, $b, $c): int {
        return max($a, $b, $c);
    }

    // Returns the maximum value in an array of shorts
    public static function maxShort(...$array): int {
        return max($array);
    }

    // Gets the maximum of three short values
    public static function maxShort3($a, $b, $c): int {
        return max($a, $b, $c);
    }

    // Returns the minimum value in an array of bytes
    public static function minByte(...$array): int {
        return min($array);
    }

    // Gets the minimum of three byte values
    public static function minByte3($a, $b, $c): int {
        return min($a, $b, $c);
    }

    // Returns the minimum value in an array of doubles
    public static function minDouble(...$array): float {
        return min($array);
    }

    // Gets the minimum of three double values
    public static function minDouble3($a, $b, $c): float {
        return min($a, $b, $c);
    }

    // Returns the minimum value in an array of floats
    public static function minFloat(...$array): float {
        return min($array);
    }

    // Gets the minimum of three float values
    public static function minFloat3($a, $b, $c): float {
        return min($a, $b, $c);
    }

    // Returns the minimum value in an array of ints
    public static function minInt(...$array): int {
        return min($array);
    }

    // Gets the minimum of three int values
    public static function minInt3($a, $b, $c): int {
        return min($a, $b, $c);
    }

    // Returns the minimum value in an array of longs
    public static function minLong(...$array): int {
        return min($array);
    }

    // Gets the minimum of three long values
    public static function minLong3($a, $b, $c): int {
        return min($a, $b, $c);
    }

    // Returns the minimum value in an array of shorts
    public static function minShort(...$array): int {
        return min($array);
    }

    // Gets the minimum of three short values
    public static function minShort3($a, $b, $c): int {
        return min($a, $b, $c);
    }

    // Converts a String to a byte, returning zero if the conversion fails
    public static function toByte($str): int {
        return (is_numeric($str)) ? (int)$str : 0;
    }

    // Converts a String to a byte, returning a default value if the conversion fails
    public static function toByteWithDefault($str, $defaultValue): int {
        return (is_numeric($str)) ? (int)$str : $defaultValue;
    }

    // Converts a String to a double, returning 0.0d if the conversion fails
    public static function toDouble($str): float {
        return (is_numeric($str)) ? (double)$str : 0.0;
    }

    // Converts a String to a double, returning a default value if the conversion fails
    public static function toDoubleWithDefault($str, $defaultValue): float {
        return (is_numeric($str)) ? (double)$str : $defaultValue;
    }

    // Converts a BigDecimal to a double
    public static function toDoubleFromBigDecimal($value): float {
        return (double)$value;
    }

    // Converts a BigDecimal to a double with a default value
    public static function toDoubleFromBigDecimalWithDefault($value, $defaultValue): float {
        return $value ? (double)$value : $defaultValue;
    }

    // Converts a String to a float, returning 0.0f if the conversion fails
    public static function toFloat($str): float {
        return (is_numeric($str)) ? (float)$str : 0.0;
    }

    // Converts a String to a float, returning a default value if the conversion fails
    public static function toFloatWithDefault($str, $defaultValue): float {
        return (is_numeric($str)) ? (float)$str : $defaultValue;
    }

    // Converts a String to an int, returning zero if the conversion fails
    public static function toInt($str): int {
        return (is_numeric($str)) ? (int)$str : 0;
    }

    // Converts a String to an int, returning a default value if the conversion fails
    public static function toIntWithDefault($str, $defaultValue): int {
        return (is_numeric($str)) ? (int)$str : $defaultValue;
    }

    // Converts a String to a long, returning zero if the conversion fails
    public static function toLong($str): int {
        return (is_numeric($str)) ? (int)$str : 0;
    }

    // Converts a String to a long, returning a default value if the conversion fails
    public static function toLongWithDefault($str, $defaultValue): int {
        return (is_numeric($str)) ? (int)$str : $defaultValue;
    }

    // Converts a Double to a BigDecimal with a scale of two
    public static function toScaledBigDecimalFromDouble($value): float {
        return round($value, 2);
    }

    // Converts a Double to a BigDecimal with the specified scale and rounding mode
    public static function toScaledBigDecimalFromDoubleWithScale($value, $scale): float {
        return round($value, $scale);
    }

    // Converts a String to a BigDecimal with a scale of two
    public static function toScaledBigDecimalFromString($value): float {
        return round((double)$value, 2);
    }

    // Converts a String to a BigDecimal with the specified scale and rounding mode
    public static function toScaledBigDecimalFromStringWithScale($value, $scale): float {
        return round((double)$value, $scale);
    }

    // Converts a BigDecimal to a BigDecimal with a scale of two
    public static function toScaledBigDecimalFromBigDecimal($value): float {
        return round($value, 2);
    }

    // Converts a BigDecimal to a BigDecimal with the specified scale and rounding mode
    public static function toScaledBigDecimalFromBigDecimalWithScale($value, $scale): float {
        return round($value, $scale);
    }

    // Converts a String to a short, returning zero if the conversion fails
    public static function toShort($str): int {
        return (is_numeric($str)) ? (int)$str : 0;
    }

    // Converts a String to a short, returning a default value if the conversion fails
    public static function toShortWithDefault($str, $defaultValue): int {
        return (is_numeric($str)) ? (int)$str : $defaultValue;
    }

    // Compares two numbers and returns true if x is greater than y
    public static function isGreaterThan($x, $y): bool {
        return $x > $y;
    }

    // Compares two numbers and returns true if x is less than y
    public static function isLessThan($x, $y): bool {
        return $x < $y;
    }

    // Compares two numbers and returns true if x is greater than or equal to y
    public static function isGreaterThanOrEqual($x, $y): bool {
        return $x >= $y;
    }

    // Compares two numbers and returns true if x is less than or equal to y
    public static function isLessThanOrEqual($x, $y): bool {
        return $x <= $y;
    }

    // Compares two numbers and returns true if x is equal to y
    public static function isEqualTo($x, $y): bool {
        return $x == $y;
    }

    // Compares two numbers and returns true if x is not equal to y
    public static function isNotEqualTo($x, $y): bool {
        return $x != $y;
    }



}
