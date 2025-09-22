<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum LotStatus: string
{
    use EnumToArray;

    case PENDING = 'pending';
    case ACTIVE = 'active';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';
}
