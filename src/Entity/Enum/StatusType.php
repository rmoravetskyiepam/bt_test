<?php

namespace App\Entity\Enum;

enum StatusType: string
{
    use EnumToArray;

    case  OPEN = 'Open';
    case  IN_PROGRESS = 'In Progress';
    case  FIXED = 'Fixed';
    case  WONT_FIX = 'Won\'t Fix';
    case  CANCELED = 'Canceled';
}
