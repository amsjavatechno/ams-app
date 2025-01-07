<?php

namespace AmsApp\Dao;
require __DIR__.'/../vendor/autoload.php';
use PDO;

class RolePermissionDao extends CommonDao
{
    public function getPermissionsByRole($role_id)
    {
        $query = "SELECT * FROM role_permissions WHERE role_id = :role_id";
        return $this->fetchAll($query, ['role_id' => $role_id]);
    }

    public function insertRolePermission($role_id, $permission_id)
    {
        $query = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:role_id, :permission_id)";
        return $this->insert($query, [
            'role_id' => $role_id,
            'permission_id' => $permission_id
        ]);
    }

    public function deleteRolePermission($role_id, $permission_id)
    {
        $query = "DELETE FROM role_permissions WHERE role_id = :role_id AND permission_id = :permission_id";
        return $this->delete($query, [
            'role_id' => $role_id,
            'permission_id' => $permission_id
        ]);
    }
}
?>
