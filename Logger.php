<?php
namespace AmsApp;
require_once __DIR__ . '/vendor/autoload.php';
use AmsApp\Utils\NumberUtils;
use AmsApp\Utils\PhpList\PhpList;
use AmsApp\Utils\CollectionUtils;

class Logger
{
    private const  DEBUG = 'DEBUG';
    private const INFO = 'INFO';
    private const WARNING = 'WARNING';
    private const ERROR = 'ERROR';
    private const CRITICAL = 'CRITICAL';
    private $logFile;
    private $logLevel;
    private static $instance;
    private PhpList $logLevels;

    private function __construct()
    {
        $this->logLevels = CollectionUtils::asList([self::DEBUG, self::INFO, self::WARNING, self::ERROR, self::CRITICAL]);
        $config = parse_ini_file(__DIR__ . '/config.properties');

        $this->logFile = $config['log.path'];
        $this->logLevel = strtoupper($config['log.level']);

        // Ensure the directory exists
        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0750, true);
        }
        // Set PHP error logging to the specified file
        ini_set('log_errors', 1);
        ini_set('error_log', $this->logFile);
        // Rotate log if it exceeds a size limit (e.g., 5MB)
        $this->rotateLog(5 * 1024 * 1024); // 5MB
    }

    /**
     * Log a message with a specific log level.
     *
     * @param string $level The log level (DEBUG, INFO, WARNING, ERROR, CRITICAL)
     * @param string $message The log message
     */
    public function log(string $level, string $message)
    {
        if (!$this->logLevels->contains($this->logLevel)) {
            throw new InvalidArgumentException("Invalid log level: $this->logLevel");
        }

        // Only log messages at or above the configured level
        if (NumberUtils::isGreaterThanOrEqual($this->logLevels->getIndex($level), $this->logLevels->getIndex($this->logLevel))) {
            $timestamp = date('Y-m-d H:i:s');
            error_log("[$level] $timestamp - $message\n", 3, $this->logFile);
        }
    }

    public function log_error(string $message): void
    {
        $this->log(self::ERROR, $message);
    }

    public function log_info(string $message)
    {
        $this->log(self::INFO, $message);
    }

    public function log_debug(string $message)
    {
        $this->log(self::DEBUG, $message);
    }

    public function log_warning(string $message)
    {
        $this->log(self::WARNING, $message);
    }

    public function log_critical(string $message)
    {
        $this->log(self::CRITICAL, $message);
    }

    /**
     * Rotate the log file if it exceeds the specified size.
     *
     * @param int $maxSize The maximum file size in bytes before rotation
     */
    private function rotateLog($maxSize)
    {
        if (file_exists($this->logFile) && filesize($this->logFile) > $maxSize) {
            $rotatedFile = $this->logFile . '.' . date('YmdHis');
            rename($this->logFile, $rotatedFile);

            // Optionally compress the rotated file
            if (function_exists('gzcompress')) {
                file_put_contents($rotatedFile . '.gz', gzcompress(file_get_contents($rotatedFile)));
                unlink($rotatedFile); // Delete the uncompressed rotated file
            }
        }
    }

    public static function getInstance(): Logger
    {
        if (self::$instance === null) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }
}

// Initialize the Logger instance
$logger = Logger::getInstance();

// Test log entry moved outside the constructor
$logger->log_info("Logging initialized.");
