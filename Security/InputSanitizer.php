<?php

namespace AmsApp\Security;

use AmsApp\Utils\BaseUtils;

class InputSanitizer
{

    const STRING_SANITIZER = 'string';
    const URL_SANITIZER = 'url';
    const EMAIL_SANITIZER = 'email';
    const ARRAY_SANITIZER = 'array';

    /**
     * Sanitize input data to prevent common security risks.
     *
     * @param mixed $input The input data to sanitize. It can be a string, array, or a combination.
     * @param string $type The type of input (e.g., 'string', 'email', 'url', 'array').
     * @return mixed The sanitized input data.
     */
    public static function sanitize(mixed $input, string $type = 'string'): mixed
    {
        if (BaseUtils::isNotNull($input)) {
            // If input is an array, recursively sanitize each element
            if (is_array($input)) {
                foreach ($input as &$item) {
                    $item = self::sanitize($item, $type);
                }
                return $input;
            }

            // Perform sanitization based on input type
            switch ($type) {
                case 'email':
                    return filter_var($input, FILTER_SANITIZE_EMAIL);

                case 'url':
                    return filter_var($input, FILTER_SANITIZE_URL);

                case 'string':
                default:
                    // Trim leading/trailing spaces
                    $input = trim($input);

                    // Sanitize HTML characters to prevent XSS
                    $input = SecurityUtil::sanitizeOutput($input);

                    // Remove unwanted characters for SQL safety (e.g., if you expect only alphanumeric)
                    $input = preg_replace("/[^a-zA-Z0-9\s]/", "", $input);
                    break;
            }
        }

        return $input;
    }
}