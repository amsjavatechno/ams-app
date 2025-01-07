<?php

namespace AmsApp\Dao;
require __DIR__ . '/../vendor/autoload.php';

class UserDao extends CommonDao
{
    /**
     * Get user by user_id.
     *
     * @param int $user_id The user ID.
     * @return array The user data.
     */
    public function getUserById($user_id)
    {
        $query = "SELECT * FROM users WHERE user_id = :user_id";
        return $this->fetchOne($query, ['user_id' => $user_id]);
    }

    /**
     * Get user by email.
     *
     * @param string $email The user's email.
     * @return array The user data.
     */
    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->fetchOne($query, ['email' => $email]);
    }

    /**
     * Insert a new user.
     *
     * @param int $user_id The user ID.
     * @param string $name The user's name.
     * @param string $email The user's email.
     * @param string $password_hash The hashed password.
     * @param int $gender_id The gender ID.
     * @param int $status_id The status ID.
     * @param int $version_id The version ID (typically 0 for new records).
     * @return int The ID of the inserted user.
     */
    public function insertUser($user_id, $name, $email, $password_hash, $gender_id, $status_id, $version_id): int
    {
        $query = "INSERT INTO users (user_id, name, email, password_hash, gender_id, status_id, version_id) 
                  VALUES (:user_id, :name, :email, :password_hash, :gender_id, :status_id, :version_id)";
        return $this->insert($query, [
            'user_id' => $user_id,
            'name' => $name,
            'email' => $email,
            'password_hash' => $password_hash,
            'gender_id' => $gender_id,
            'status_id' => $status_id,
            'version_id' => $version_id
        ]);
    }



        // Modified method to only take name, email, and password_hash for user registration
    public function createUser($name, $email, $password_hash): int
    {
        // Set default values for gender_id, status_id, and version_id
        $gender_id = null; // Default gender (you can change this if required)
        $status_id = 1; // Default status (active or whatever is applicable)
        $version_id = 1; // Default version ID (change it as required)

        // The query to insert the user into the database
        $query = "INSERT INTO users (name, email, password_hash, gender_id, status_id, version_id) 
                  VALUES (:name, :email, :password_hash, :gender_id, :status_id, :version_id)";

        // Execute the query and return the result (inserted user ID or failure)
        return $this->insert($query, [
            'name' => $name,
            'email' => $email,
            'password_hash' => $password_hash,
            'gender_id' => $gender_id,
            'status_id' => $status_id,
            'version_id' => $version_id
        ]);
    }





    /**
     * Update an existing user with optimistic locking.
     *
     * @param int $user_id The user ID.
     * @param string $name The user's name.
     * @param string $email The user's email.
     * @param string $password_hash The hashed password.
     * @param int $gender_id The gender ID.
     * @param int $status_id The status ID.
     * @param int $version_id The version ID to check.
     * @return bool True if the update was successful, false if there was a version conflict.
     */
    public function updateUser($user_id, $name, $email, $password_hash, $gender_id, $status_id, $version_id)
    {
        // Fetch the current version_id from the database
        $query = "SELECT version_id FROM users WHERE user_id = :user_id";
        $currentVersion = $this->fetchOne($query, ['user_id' => $user_id]);

        if ($currentVersion) {
            // Check if the provided version_id matches the current version in the database
            if ($currentVersion['version_id'] !== $version_id) {
                // Version conflict, the record has been updated since it was last fetched
                return false;  // Optimistic Locking failure
            }

            // If versions match, increment the version_id and update the record
            $new_version_id = $currentVersion['version_id'] + 1;

            $query = "UPDATE users 
                      SET name = :name, email = :email, password_hash = :password_hash, gender_id = :gender_id, 
                          status_id = :status_id, version_id = :new_version_id 
                      WHERE user_id = :user_id";
            $this->update($query, [
                'user_id' => $user_id,
                'name' => $name,
                'email' => $email,
                'password_hash' => $password_hash,
                'gender_id' => $gender_id,
                'status_id' => $status_id,
                'new_version_id' => $new_version_id
            ]);
            return true;  // Successful update
        }

        return false;  // Record not found
    }

    /**
     * Delete a user by user_id.
     *
     * @param int $user_id The user ID.
     * @return int The number of rows affected.
     */
    public function deleteUser($user_id)
    {
        $query = "DELETE FROM users WHERE user_id = :user_id";
        return $this->delete($query, ['user_id' => $user_id]);
    }
}
?>
