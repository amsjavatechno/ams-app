<?php

namespace AmsApp\Utils\Http;

use AmsApp\Constants\BaseConstants;
use AmsApp\Exceptions\ExceptionBuilder;

class HttpBaseUtil
{

    const CONTENT_TYPE_JSON = 'application/json';
    const CONTENT_TYPE_FORM = 'application/x-www-form-urlencoded';

    const GET_METHOD = 'GET';

    const POST_METHOD = 'POST';
    const PUT_METHOD = 'PUT';
    const DELETE_METHOD = 'DELETE';


    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_NO_CONTENT = 204;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_SERVICE_UNAVAILABLE = 503;


    /**
     * Verify if the HTTP request method matches the expected method.
     *
     * @param string $expectedMethod The expected HTTP method (GET, POST, PUT, DELETE, etc.)
     * @return bool True if the method matches, false otherwise.
     */
    public static function verifyMethod(string $expectedMethod): bool
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) === strtoupper($expectedMethod);
    }

    /**
     * Set the response header for the content type.
     *
     * @param string $contentType The content type to set (application/json, application/xml, etc.)
     * @param int $statusCode The HTTP status code (default: 200)
     */
    public static function setResponseHeaders(string $contentType = self::CONTENT_TYPE_JSON, int $statusCode = 200): void
    {
        // Set the content type header
        header("Content-Type: $contentType");
        // Set the status code header
        http_response_code($statusCode);
    }

    /**
     * Handle the request method validation.
     * Responds with a 405 Method Not Allowed if the method does not match.
     *
     * @param string $expectedMethod The expected HTTP method (GET, POST, PUT, DELETE).
     */
    public static function handleMethodValidation(string $expectedMethod): void
    {
        if (!self::verifyMethod($expectedMethod)) {
            // Set the response headers
            self::setResponseHeaders(self::CONTENT_TYPE_JSON, 405);
            // Send the error message in JSON format
            echo json_encode([
                'error' => 'Method Not Allowed',
                'message' => "The request method must be $expectedMethod"
            ]);
            exit();
        }
    }

    /**
     * Handle request to ensure content type is application/json.
     */
    public static function verifyJsonContentType(): void
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (!str_contains($contentType, self::CONTENT_TYPE_JSON)) {
            // Set response headers
            self::setResponseHeaders(self::CONTENT_TYPE_JSON, 415); // Unsupported Media Type

            // Send error message
            echo json_encode([
                'error' => 'Unsupported Media Type',
                'message' => 'Content-Type must be application/json'
            ]);
            exit();
        }
    }

    /**
     * Parse JSON input for POST and PUT requests.
     *
     * @return array Parsed JSON data from the request body.
     */
    public static function parseJsonInput(): array
    {
        $inputData = file_get_contents("php://input");
        $parsedData = json_decode($inputData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Set response headers
            self::setResponseHeaders(self::CONTENT_TYPE_JSON, 400); // Bad Request

            // Send error message
            echo json_encode([
                'error' => 'Bad Request',
                'message' => 'Invalid JSON data received'
            ]);
            exit();
        }

        return $parsedData;
    }

    public static function validatePostRequest(): void
    {
        // Check if the request method is POST
        if (!self::verifyMethod(HttpBaseUtil::POST_METHOD)) {
            ExceptionBuilder::create()->withCode(self::HTTP_METHOD_NOT_ALLOWED)->withMessage(BaseConstants::INVALID_REQUEST_METHOD_ONLY_POST_REQUESTS_ARE_ALLOWED)->build()->throwNow();
        }
    }
}
