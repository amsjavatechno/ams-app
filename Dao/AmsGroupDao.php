<?php

namespace AmsApp\Dao;

require __DIR__ . '/../vendor/autoload.php';

use PDO;

class AmsGroupDao extends CommonDao
{
    /**
     * Get a group by its ID.
     *
     * @param int $group_id The group ID.
     * @return array|null The group data or null if not found.
     */
    public function getGroupById(int $group_id): ?array
    {
        $query = "SELECT * FROM ams_groups WHERE group_id = :group_id";
        return $this->fetchOne($query, ['group_id' => $group_id]);
    }

    /**
     * Insert a new group.
     *
     * @param int $group_id The group ID.
     * @param string $group_name The name of the group.
     * @param string $group_description The description of the group.
     * @param int $created_by The ID of the user who created the group.
     * @param int $status_id The status ID of the group.
     * @param int $version_id The version ID (0 for new records).
     * @return int The ID of the newly inserted group.
     */
    public function insertGroup(int $group_id, string $group_name, string $group_description, int $created_by, int $status_id, int $version_id = 0): int
    {
        $query = "INSERT INTO ams_groups (group_id, group_name, group_description, created_by, status_id, version_id) 
                  VALUES (:group_id, :group_name, :group_description, :created_by, :status_id, :version_id)";
        return $this->insert($query, [
            'group_id' => $group_id,
            'group_name' => $group_name,
            'group_description' => $group_description,
            'created_by' => $created_by,
            'status_id' => $status_id,
            'version_id' => $version_id
        ]);
    }

    /**
     * Update an existing group with optimistic locking.
     *
     * @param int $group_id The group ID.
     * @param string $group_name The name of the group.
     * @param string $group_description The description of the group.
     * @param int $status_id The status ID of the group.
     * @param int $version_id The version ID to check for optimistic locking.
     * @param int $new_version_id The new version ID (incremented on successful update).
     * @return bool True if the update was successful, false if there was a version conflict.
     */
    public function updateGroup(int $group_id, string $group_name, string $group_description, int $status_id, int $version_id, int &$new_version_id): bool
    {
        // Fetch current version_id from database
        $query = "SELECT version_id FROM ams_groups WHERE group_id = :group_id";
        $currentVersion = $this->fetchOne($query, ['group_id' => $group_id]);

        if ($currentVersion) {
            // Check if the provided version_id matches the current version in the database
            if ($currentVersion['version_id'] !== $version_id) {
                // Version conflict, the record has been updated since the original fetch
                return false;
            }

            // If versions match, increment the version and update the record
            $new_version_id = $currentVersion['version_id'] + 1;

            $query = "UPDATE ams_groups 
                      SET group_name = :group_name, group_description = :group_description, status_id = :status_id, version_id = :new_version_id 
                      WHERE group_id = :group_id";
            $this->update($query, [
                'group_id' => $group_id,
                'group_name' => $group_name,
                'group_description' => $group_description,
                'status_id' => $status_id,
                'new_version_id' => $new_version_id
            ]);
            return true;
        }

        return false;  // Record not found
    }

    /**
     * Delete a group by its ID.
     *
     * @param int $group_id The group ID.
     * @return int The number of rows affected.
     */
    public function deleteGroup(int $group_id): int
    {
        $query = "DELETE FROM ams_groups WHERE group_id = :group_id";
        return $this->delete($query, ['group_id' => $group_id]);
    }
}
?>
