<?php

namespace AmsApp\Enums;


enum Permission: string
{
    case CreateGroup = 'CD';
    case DeleteGroup = 'DG';
    case ModifyGroup = 'MG';
    case AddMember = 'AM';
    case RemoveMember = 'RM';
    case TransferOwnership = 'TO';
    case ViewTransactions = 'VT';

    public function description(): string
    {
        return match ($this) {
            self::CreateGroup => 'Permission to create a new group',
            self::DeleteGroup => 'Permission to delete a group',
            self::ModifyGroup => 'Permission to modify group details (e.g., name, description)',
            self::AddMember => 'Permission to add members to a group',
            self::RemoveMember => 'Permission to remove members from a group',
            self::TransferOwnership => 'Permission to transfer group ownership',
            self::ViewTransactions => 'Permission to view transactions within a group',
        };
    }
}
