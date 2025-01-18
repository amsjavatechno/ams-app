<?php

namespace AmsApp\Auth;

class SessionManager
{
    // Start session when the class is instantiated
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Method to handle login
    public function login($userId, $userName, $userEmail, $role, $isAdmin = false, $isSuperAdmin = false): void
    {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = $userName;
        $_SESSION['user_email'] = $userEmail;
        $_SESSION['role'] = $role;
        $_SESSION['is_admin'] = $isAdmin;
        $_SESSION['is_super_admin'] = $isSuperAdmin;
        $_SESSION['logged_in'] = true;
    }

    // Method to handle logout
    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }

    // Check if user is logged in
    public function isLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    // Check if the current user is an admin
    public function isAdmin()
    {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }

    // Check if the current user is a super admin
    public function isSuperAdmin()
    {
        return isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin'] === true;
    }

    // Check if the current user is a member
    public function isMember()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'member';
    }

    // Check if the current user has specific permission
    public function hasPermission($permission): bool
    {
        // This assumes that permissions are stored in session or can be retrieved via role.
        if (isset($_SESSION['role'])) {
            $permissions = $this->getPermissionsByRole($_SESSION['role']);
            return in_array($permission, $permissions);
        }
        return false;
    }

    // This method will return an array of permissions based on the user's role
    private function getPermissionsByRole($role): array
    {
        // Define role-based permissions (This can also be fetched from the database)
        $permissions = [
            'admin' => ['view_dashboard', 'edit_users', 'delete_users', 'manage_roles'],
            'super_admin' => ['view_dashboard', 'edit_users', 'delete_users', 'manage_roles', 'manage_system'],
            'member' => ['view_dashboard', 'view_profile'],
        ];

        return isset($permissions[$role]) ? $permissions[$role] : [];
    }

    // Check if the user has a specific role
    public function hasRole($role)
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }

    // Redirect user to login page if not logged in
    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            header('Location: login.php');
            exit;
        }
    }

    // Redirect user if not an admin
    public function requireAdmin()
    {
        if (!$this->isAdmin()) {
            header('Location: forbidden.php');
            exit;
        }
    }

    // Redirect user if not a super admin
    public function requireSuperAdmin(): void
    {
        if (!$this->isSuperAdmin()) {
            header('Location: forbidden.php');
            exit;
        }
    }

    // Check if the current user has a specific permission
    public function requirePermission($permission)
    {
        if (!$this->hasPermission($permission)) {
            header('Location: forbidden.php');
            exit;
        }
    }

    // Get the current user's ID
    public function getUserId()
    {
        return $_SESSION['user_id'] ?? null;
    }

    // Get the current user's name
    public function getUserName()
    {
        return $_SESSION['user_name'] ?? null;
    }

    // Get the current user's email
    public function getUserEmail()
    {
        return $_SESSION['user_email'] ?? null;
    }

    // Get the current user's role
    public function getUserRole()
    {
        return $_SESSION['role'] ?? null;
    }

    // Check if the current user is logged in and has a specific role
    public function isRoleLoggedIn($role): bool
    {
        return $this->isLoggedIn() && $this->hasRole($role);
    }


}

?>
