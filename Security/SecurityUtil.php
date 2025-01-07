<?php

namespace AmsApp\Security;
class SecurityUtil
{
    /**
     * Sanitize and escape output to prevent XSS.
     *
     * @param string $input The user input to sanitize.
     * @return string The sanitized and escaped string.
     */
    public static function sanitizeOutput(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize input by stripping tags and trimming whitespace.
     *
     * @param string $input The user input to sanitize.
     * @return string The sanitized string.
     */
    public static function sanitizeInput(string $input): string
    {
        return trim(strip_tags($input));
    }
}
