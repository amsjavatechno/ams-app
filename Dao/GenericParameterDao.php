<?php

namespace AmsApp\Dao;

require __DIR__ . '/../vendor/autoload.php';

use AmsApp\Dao\CommonDao;
use PDO;

class GenericParameterDao extends CommonDao
{
    /**
     * Get all parameters by dtype.
     *
     * @param string $dtype The data type.
     * @return array The list of parameters.
     */
    public function getAllParameters(string $dtype): array
    {
        $query = "SELECT * FROM generic_constants_param WHERE dtype = :dtype AND active_status = 1";
        return $this->fetchAll($query, ['dtype' => $dtype]);
    }

    /**
     * Get a specific parameter by dtype and code.
     *
     * @param string $dtype The data type.
     * @param string $code The parameter code.
     * @return array|null The parameter data or null if not found.
     */
    public function getParameterByCode(string $dtype, string $code): ?array
    {
        $query = "SELECT * FROM generic_constants_param WHERE dtype = :dtype AND code = :code AND active_status = 1";
        return $this->fetchOne($query, ['dtype' => $dtype, 'code' => $code]);
    }

    /**
     * Insert a new parameter.
     *
     * @param string $dtype The data type.
     * @param string $code The parameter code.
     * @param string $description The description of the parameter.
     * @param int $version_id The version ID, usually 0 for new records.
     * @param int $active_status The active status (1 for active, 0 for inactive).
     * @return int The ID of the newly inserted parameter.
     */
    public function insertParameter(string $dtype, string $code, string $description, int $version_id, int $active_status): int
    {
        $query = "INSERT INTO generic_constants_param (dtype, code, description, version_id, active_status) 
                  VALUES (:dtype, :code, :description, :version_id, :active_status)";
        return $this->insert($query, [
            'dtype' => $dtype,
            'code' => $code,
            'description' => $description,
            'version_id' => $version_id,
            'active_status' => $active_status
        ]);
    }

    /**
     * Update an existing parameter with optimistic locking.
     *
     * @param int $id The parameter ID.
     * @param string $dtype The data type.
     * @param string $code The parameter code.
     * @param string $description The description of the parameter.
     * @param int $version_id The version ID to check.
     * @param int $active_status The active status.
     * @return bool True if the update was successful, false if there was a version conflict.
     */
    public function updateParameter(int $id, string $dtype, string $code, string $description, int $version_id, int $active_status): bool
    {
        // Fetch the current version_id from the database
        $query = "SELECT version_id FROM generic_constants_param WHERE id = :id";
        $currentVersion = $this->fetchOne($query, ['id' => $id]);

        if ($currentVersion) {
            // Check if the provided version_id matches the current version in the database
            if ($currentVersion['version_id'] !== $version_id) {
                // Version conflict, the record has been updated since it was last fetched
                return false;  // Optimistic Locking failure
            }

            // If versions match, increment the version_id and update the record
            $new_version_id = $currentVersion['version_id'] + 1;

            $query = "UPDATE generic_constants_param 
                      SET dtype = :dtype, code = :code, description = :description, version_id = :new_version_id, active_status = :active_status 
                      WHERE id = :id";
            $this->update($query, [
                'id' => $id,
                'dtype' => $dtype,
                'code' => $code,
                'description' => $description,
                'new_version_id' => $new_version_id,
                'active_status' => $active_status
            ]);
            return true;  // Successful update
        }

        return false;  // Record not found
    }

    /**
     * Delete a parameter by its ID.
     *
     * @param int $id The parameter ID.
     * @return int The number of rows affected.
     */
    public function deleteParameter(int $id): int
    {
        $query = "DELETE FROM generic_constants_param WHERE id = :id";
        return $this->delete($query, ['id' => $id]);
    }
}
?>
