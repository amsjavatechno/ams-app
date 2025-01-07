<?php

namespace AmsApp\Dao;
use AmsApp\Logger;
use PDO;
use Exception;

class TransactionManagerUtil
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Execute multiple dependent queries within a transaction.
     *
     * @param callable $transactionCallback The callback function containing the dependent queries.
     * @return mixed The result of the callback function on success.
     * @throws Exception If any query fails, it will throw an exception.
     */
    public function executeTransaction(callable $transactionCallback)
    {
        try {
            // Start the transaction
            $this->pdo->beginTransaction();

            // Execute the callback function
            $result = $transactionCallback($this->pdo);
            // Commit the transaction
            $this->pdo->commit();
            return $result;
        } catch (Exception $e) {
            // Roll back the transaction on failure
            $this->pdo->rollBack();
            // Re-throw the exception for further handling
            Logger::getInstance()->log_error(" Roll back opertion permormed : " . $e);
        }
    }
}


//example


//require_once 'TransactionManager.php';
//
//use AmsApp\Database\TransactionManager;
//
//try {
//    // Set up the PDO connection
//    $dsn = 'mysql:host=localhost;dbname=testdb;charset=utf8mb4';
//    $username = 'root';
//    $password = '';
//    $pdo = new PDO($dsn, $username, $password, [
//        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//    ]);
//
//    // Create the TransactionManager instance
//    $transactionManager = new TransactionManager($pdo);
//
//    // Execute the transaction
//    $transactionManager->executeTransaction(function (PDO $pdo) {
//        // Query 1: Insert into table A
//        $stmt1 = $pdo->prepare("INSERT INTO table_a (name, value) VALUES (:name, :value)");
//        $stmt1->execute([
//            ':name' => 'Item A',
//            ':value' => 100,
//        ]);
//
//        // Get the last inserted ID (if necessary for dependent queries)
//        $lastInsertedId = $pdo->lastInsertId();
//
//        // Query 2: Insert into table B (dependent on table A)
//        $stmt2 = $pdo->prepare("INSERT INTO table_b (table_a_id, description) VALUES (:table_a_id, :description)");
//        $stmt2->execute([
//            ':table_a_id' => $lastInsertedId,
//            ':description' => 'Related to Item A',
//        ]);
//
//        // Query 3: Update table C
//        $stmt3 = $pdo->prepare("UPDATE table_c SET status = :status WHERE id = :id");
//        $stmt3->execute([
//            ':status' => 'processed',
//            ':id' => 1,
//        ]);
//
//        // Optionally return a result
//        return 'Transaction successful!';
//    });
//
//    echo 'All queries executed successfully!';
//} catch (Exception $e) {
//    // Handle any errors
//    echo 'Transaction failed: ' . $e->getMessage();
//}

