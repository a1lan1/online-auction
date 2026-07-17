<?php

declare(strict_types=1);

namespace App\States\Lot;

use App\States\LotState;

class Cancelled extends LotState
{
    public static string $name = 'cancelled';
}
