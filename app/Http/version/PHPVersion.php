<?php
namespace blog\Http\version;

use Exception;

class PHPVersion
{
    public function __construct(string $version = '7.4') // Default to PHP 7.0.0 if no version is provided
    {
        $this->version($version);
    }

    public static function version(string $version)
    {
        $currentVersion = phpversion();
        $isCompatible = version_compare($currentVersion, $version, '>=');
        if (!$isCompatible) {
            echo 'PHP version: Must be above' . $version;
            exit;
        }
    }
}

