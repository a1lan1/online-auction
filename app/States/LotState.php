<?php

declare(strict_types=1);

namespace App\States;

use App\States\Lot\Active;
use App\States\Lot\Cancelled;
use App\States\Lot\NotSold;
use App\States\Lot\Pending;
use App\States\Lot\Sold;
use Override;
use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class LotState extends State
{
    /**
     * @throws InvalidConfig
     */
    #[Override]
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->registerState([
                Pending::class,
                Active::class,
                Sold::class,
                NotSold::class,
                Cancelled::class,
            ])
            ->allowTransition(Pending::class, Active::class)
            ->allowTransition(Active::class, Sold::class)
            ->allowTransition(Active::class, NotSold::class)
            ->allowTransition(Active::class, Cancelled::class);
    }
}
