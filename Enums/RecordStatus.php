<?php

namespace AmsApp\Enums;
enum RecordStatus: string
{
    case Active = 'Active';
    case Inactive = 'Inactive';
    case Deleted = 'Deleted';

    public function description(): string
    {
        return match ($this) {
            self::Active => 'Record is active and available for use',
            self::Inactive => 'Record is inactive and not available for use',
            self::Deleted => 'Record has been deleted and is no longer in use',
        };
    }
}
