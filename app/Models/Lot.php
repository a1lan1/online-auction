<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property numeric $starting_price
 * @property numeric $current_price
 * @property int $auction_id
 * @property Carbon $starts_at
 * @property Carbon $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Auction $auction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bid> $bids
 * @property-read int|null $bids_count
 *
 * @method static \Database\Factories\LotFactory factory($count = null, $state = [])
 * @method static Builder<static>|Lot newModelQuery()
 * @method static Builder<static>|Lot newQuery()
 * @method static Builder<static>|Lot query()
 * @method static Builder<static>|Lot whereAuctionId($value)
 * @method static Builder<static>|Lot whereCreatedAt($value)
 * @method static Builder<static>|Lot whereCurrentPrice($value)
 * @method static Builder<static>|Lot whereDescription($value)
 * @method static Builder<static>|Lot whereEndsAt($value)
 * @method static Builder<static>|Lot whereId($value)
 * @method static Builder<static>|Lot whereStartingPrice($value)
 * @method static Builder<static>|Lot whereStartsAt($value)
 * @method static Builder<static>|Lot whereTitle($value)
 * @method static Builder<static>|Lot whereUpdatedAt($value)
 * @method static Builder<static>|Lot whereWinnerId($value)
 * @method static Builder<static>|Lot whereWinningBidId($value)
 *
 * @mixin \Eloquent
 */
class Lot extends Model
{
    /** @use HasFactory<\Database\Factories\LotFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'starting_price',
        'current_price',
        'starts_at',
        'ends_at',
        'auction_id',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'starting_price' => 'decimal:2',
            'current_price' => 'decimal:2',
        ];
    }

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
