<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\EnumToArray;

enum LotStatus: string
{
    use EnumToArray;

    case PENDING = 'pending';
    case ACTIVE = 'active';
    case SOLD = 'sold';
    case NOT_SOLD = 'not_sold';
    case CANCELLED = 'cancelled';
}
