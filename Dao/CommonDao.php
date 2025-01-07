<?php

namespace AmsApp\Dao;

use AmsApp\Configuration\Database;
use PDO;
use PDOException;
use PDOStatement;

class CommonDao
{
    private $pdo;

    /**
     * Constructor to initialize the database connection.
     */
    public function __construct()
    {
        try {
            $this->pdo = Database::getInstance()->getConnection();
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    /**
     * Execute a prepared query.
     *
     * @param string $query  The SQL query with placeholders.
     * @param array $params  Parameters to bind to the query.
     * @return PDOStatement  The executed statement.
     * @throws PDOException If the query execution fails.
     */
    private function executeQuery(string $query, array $params = []): PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Log the error securely here (e.g., to a file or monitoring system)
            throw new PDOException("Query execution error: " . $e->getMessage());
        }
    }

    /**
     * Fetch all rows from the query result.
     *
     * @param string $query  The SQL query with placeholders.
     * @param array $params  Parameters to bind to the query.
     * @return array         The result set as an associative array.
     */
    public function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a single row from the query result.
     *
     * @param string $query  The SQL query with placeholders.
     * @param array $params  Parameters to bind to the query.
     * @return array|null    The result row as an associative array or null if not found.
     */
    public function fetchOne(string $query, array $params = []): ?array
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Insert data into the database and return the last inserted ID.
     *
     * @param string $query  The SQL query with placeholders.
     * @param array $params  Parameters to bind to the query.
     * @return int           The ID of the last inserted row.
     */
    public function insert(string $query, array $params = []): int
    {
        $this->executeQuery($query, $params);
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Update data in the database.
     *
     * @param string $query  The SQL query with placeholders.
     * @param array $params  Parameters to bind to the query.
     * @return int           The number of affected rows.
     */
    public function update(string $query, array $params = []): int
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->rowCount();
    }

    /**
     * Delete data from the database.
     *
     * @param string $query  The SQL query with placeholders.
     * @param array $params  Parameters to bind to the query.
     * @return int           The number of affected rows.
     */
    public function delete(string $query, array $params = []): int
    {
        $stmt = $this->executeQuery($query, $params);
        return $stmt->rowCount();
    }

    /**
     * Close the database connection.
     */
    public function closeConnection(): void
    {
        $this->pdo = null;
    }
}
