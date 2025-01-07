<?php

namespace AmsApp\Utils\Http;

class ResponseBody {
    private static bool $headersSet = false;

    /**
     * Set the JSON response header.
     */
    private static function setJsonHeader(): void
    {
        if (!self::$headersSet) {
            header("Content-Type: application/json");
            self::$headersSet = true;
        }
    }

    /**
     * Standardize the response structure and set the response status, message, and code.
     *
     * @param int $statusCode The HTTP status code (e.g., 200, 400, 500).
     * @param string $status The status of the response (e.g., "success", "error").
     * @param string $message The message to return with the response.
     * @param mixed|null $data Additional data to return (optional).
     * @return void
     */
    private static function sendResponse(int $statusCode, string $status, string $message, mixed $data = null): void {
        self::setJsonHeader(); // Ensure headers are set once

        // Set the HTTP response code
        http_response_code($statusCode);

        // Create the response array
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        // Return the response as JSON
        echo json_encode($response);
        exit; // Ensure the script stops here after sending the response
    }

    /**
     * Send a success response.
     *
     * @param string $message The success message.
     * @param mixed $data Additional data to return (optional).
     * @return void
     */
    public static function sendSuccessResponse(string $message, $data = null): void {
        self::sendResponse(200, 'success', $message, $data);
    }

    /**
     * Send an error response.
     *
     * @param string $message The error message.
     * @param mixed $data Additional data to return (optional).
     * @return void
     */
    public static function sendErrorResponse(string $message, $data = null): void {
        self::sendResponse(400, 'error', $message, $data);
    }

    /**
     * Send a not found response.
     *
     * @param string $message The not found message.
     * @param mixed $data Additional data to return (optional).
     * @return void
     */
    public static function sendNotFoundResponse(string $message, $data = null): void {
        self::sendResponse(404, 'error', $message, $data);
    }

    /**
     * Send an internal server error response.
     *
     * @param string $message The internal server error message.
     * @param mixed $data Additional data to return (optional).
     * @return void
     */
    public static function sendInternalServerErrorResponse(string $message, $data = null): void {
        self::sendResponse(500, 'error', $message, $data);
    }

    /**
     * Send a response with data only (without status/message).
     *
     * @param int $statusCode The HTTP status code (e.g., 200, 400, 500).
     * @param string $status The status of the response (e.g., "success", "error").
     * @param mixed $data The data to return.
     * @return void
     */
    public static function sendDataResponse(int $statusCode, string $status, $data): void {
        self::sendResponse($statusCode, $status, '', $data);
    }
}
