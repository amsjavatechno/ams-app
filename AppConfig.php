<?php

namespace AmsApp;
require 'vendor\autoload.php';
use AmsApp\Utils\BooleanUtils;
use AmsApp\Utils\PhpMap\MapWrapper;
use AmsApp\Utils\StringUtils;
use Exception;

try {
    // Initialize constants from the .properties file
    AppConfig::initialize(__DIR__.'/config.properties');
} catch (Exception $e) {
    Logger::getInstance()->log_error("Error: " . $e->getMessage());
}

class AppConfig {
    private static $initialized = false;
    private static MapWrapper $propertiesMap;

    private function __construct()
    {}

    public static function getPropertyValueByKey(string $key):string
    {
        return self::$propertiesMap->containsKey($key)?self::$propertiesMap->get($key):StringUtils::BLANK;
    }

    public static function initialize($filePath) {
        if (self::$initialized) {
            return;
        }else{
            self::$propertiesMap = new MapWrapper();
        }
        // Check if the file exists
        if (!file_exists($filePath)) {
            throw new Exception("Configuration file not found: $filePath");
        }

        // Parse the .properties file
        $properties = parse_ini_file($filePath, true);
        if ($properties === false) {
            throw new Exception("Failed to parse configuration file: $filePath");
        }

        // Define constants for each property
        foreach ($properties as $propertyName => $propertyValue) {
            if (is_array($propertyValue)) {
                foreach ($propertyValue as $key => $value) {
                    $constantName = strtoupper($propertyName . '_' . $key);
                    if (!defined($constantName)) {
                        define($constantName, $value);
                    }
                }
            } elseif(BooleanUtils::and(!StringUtils::isEmpty($propertyName),!StringUtils::isEmpty($propertyValue))){
                self::$propertiesMap->put($propertyName,$propertyValue);
            }

        }

        self::$initialized = true;
    }
}