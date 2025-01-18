<?php

namespace AmsApp\Utils;
class CookiesUtil
{
    /**
     * Set a cookie with options for security and flexibility.
     *
     * @param string $name The name of the cookie.
     * @param string $value The value of the cookie.
     * @param int $expiry Expiration time in seconds (default: 3600 seconds / 1 hour).
     * @param string $path The path where the cookie is accessible (default: '/').
     * @param string|null $domain The domain where the cookie is accessible (default: null for current domain).
     * @param bool $secure Whether the cookie should only be sent over HTTPS (default: true).
     * @param bool $httpOnly Whether the cookie should be accessible only via HTTP (default: true).
     * @param string $sameSite SameSite policy ('Strict', 'Lax', 'None') (default: 'Strict').
     */
    public static function setCookie(
        string $name,
        string $value,
        int $expiry = 3600,
        string $path = '/',
        string $domain = null,
        bool $secure = true,
        bool $httpOnly = true,
        string $sameSite = 'Strict'
    ) :bool{
        $options = [
            'expires' => time() + $expiry,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httponly' => $httpOnly,
            'samesite' => $sameSite
        ];

       return setcookie($name, $value, $options);
    }

    /**
     * Get a cookie's value.
     *
     * @param string $name The name of the cookie.
     * @return string|null The cookie value, or null if not set.
     */
    public static function getCookie(string $name): ?string
    {
        return $_COOKIE[$name] ?? null;
    }

    /**
     * Check if a cookie exists.
     *
     * @param string $name The name of the cookie.
     * @return bool True if the cookie exists, false otherwise.
     */
    public static function hasCookie(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Delete a cookie by setting its expiration to the past.
     *
     * @param string $name The name of the cookie.
     * @param string $path The path where the cookie is accessible (default: '/').
     * @param string|null $domain The domain where the cookie is accessible (default: null for current domain).
     */
    public static function deleteCookie(string $name, string $path = '/', string $domain = null): void
    {
        self::setCookie($name, '', -3600, $path, $domain);
    }
}
