<?php

namespace blog\functions;

use blog\services\Session;

class CSRF
{
    protected static $session;

    // Initialize the Session class
    public static function init()
    {
        if (is_null(self::$session)) {
            self::$session = new Session();
        }

        // Ensure CSRF token is valid for POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['token']) || !self::validate($_POST['token'])) {
                // Invalid token, possible CSRF attack
                die("Invalid token, possible CSRF attack.");
            }
            // Invalidate the token after usage
            self::$session->remove('token');
        }
    }

    // Generate CSRF token and output hidden input field
    public static function generate()
    {
        self::init(); // Ensure session is started
        $token = bin2hex(random_bytes(32));
        self::$session->set('token', [
            'value' => $token,
            'expires' => time() + 3600 // Token expires in 1 hour
        ]);
        echo "<input name='token' value='$token' type='hidden'>";
    }

    // Validate CSRF token
    private static function validate($token)
    {
        $sessionToken = self::$session->get('token');
        if ($sessionToken && $sessionToken['value'] === $token) {
            if ($sessionToken['expires'] >= time()) {
                return true;
            }
        }
        return false;
    }
}
