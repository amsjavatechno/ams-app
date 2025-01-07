<?php

namespace AmsApp\Enums;
enum Gender: string
{
    case Male = 'Male';
    case Female = 'Female';
    case Other = 'Other';

    public function description(): string
    {
        return match ($this) {
            self::Male => 'Represents male gender',
            self::Female => 'Represents female gender',
            self::Other => 'Represents non-binary or other gender identities',
        };
    }
}
