<?php

namespace blog\services;

trait ResponseCode
{
    const SUCCESS = 200;
    const CREATED = 201;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const INTERNAL_SERVER_ERROR = 500;

    /**
     * Send an HTTP response with a given status code and display an error page.
     *
     * @param int $code The HTTP status code to send.
     * @param string|null $message The message to display on the error page.
     */
    public function sendResponse(int $code, string $message = null): void
    {
        // Send the HTTP response code
        http_response_code($code);

        // Set a default message if none is provided
        if ($message === null) {
            $message = $this->getDefaultMessageForCode($code);
        }

        // Build the path to the error page
        $errorPagePath = __DIR__ . "/../services/errors/{$code}.php";

        // Check if the error page file exists
        if (file_exists($errorPagePath)) {
            require_once $errorPagePath;
        } else {
            // Display a generic error message if the specific error page does not exist
            echo "<h1>Error {$code}</h1>";
            echo "<p>{$message}</p>";
        }

        // Exit the script to ensure no further output is sent
        exit;
    }

    /**
     * Get the default message for a given HTTP status code.
     *
     * @param int $code The HTTP status code.
     * @return string The default message.
     */
    private function getDefaultMessageForCode(int $code): string
    {
        switch ($code) {
            case self::BAD_REQUEST:
                return "Bad Request";
            case self::UNAUTHORIZED:
                return "Unauthorized";
            case self::FORBIDDEN:
                return "Forbidden";
            case self::NOT_FOUND:
                return "Not Found";
            case self::METHOD_NOT_ALLOWED:
                return "Method Not Allowed";
            case self::INTERNAL_SERVER_ERROR:
                return "Internal Server Error";
            default:
                return "An error occurred";
        }
    }
}
