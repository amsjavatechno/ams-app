<?php
namespace AmsApp\Configuration;
require_once __DIR__ . '/../vendor/autoload.php';
use AmsApp\AppConfig;
use AmsApp\Logger;
use AmsApp\Utils\BaseUtils;
use PDO;
use PDOException;

class Database
{
    private const DB_HOST = 'db.host';
    private const DB_NAME = 'db.name';
    private const DB_USERNAME = 'db.username';
    private const DB_PASSWORD = 'db.password';
    private static $instance = null;
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;
    private $logger;

    private function __construct()
    {
        $this->loadConfig();
        $this->logger = Logger::getInstance(); // Initialize the logger
        $this->getConnection();
    }

    public static function getInstance()
    {
        if (BaseUtils::isNull(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function loadConfig()
    {
        $this->host = AppConfig::getPropertyValueByKey(self::DB_HOST);
        $this->db_name = AppConfig::getPropertyValueByKey(self::DB_NAME);
        $this->username = AppConfig::getPropertyValueByKey(self::DB_USERNAME);
        $this->password = AppConfig::getPropertyValueByKey(self::DB_PASSWORD);
    }

    public function getConnection()
    {
        if (BaseUtils::isNull($this->conn) || $this->isConnectionInActive()) {
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                $this->logger->log_error("Connection error: " . $exception->getMessage());
            }
        }
        return $this->conn;
    }

    private function isConnectionActive():bool
    {
        try {
            $this->conn->query("SELECT 1"); // Test query
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    private function isConnectionInActive():bool
    {
        return !$this->isConnectionActive();
    }

}