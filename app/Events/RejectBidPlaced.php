<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RejectBidPlaced
{
    use Dispatchable;
    use SerializesModels;
}
