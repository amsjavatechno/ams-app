<?php

namespace AmsApp\Enums;
enum Role: string
{
    case SuperAdmin = 'SuperAdmin';
    case Admin = 'Admin';
    case Member = 'Member';
    case Guest = 'Guest';

    public function description(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Has full access and control over all features and settings in the system',
            self::Admin => 'Has access to most features, but limited administrative powers compared to SuperAdmin',
            self::Member => 'Standard user with basic access to features and limited control over groups',
            self::Guest => 'User with limited access, typically for view-only purposes',
        };
    }
}
