<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $auction_id
 * @property string $title
 * @property string|null $description
 * @property string $starting_price
 * @property string $current_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Auction $auction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bid> $bids
 * @property-read int|null $bids_count
 *
 * @method static \Database\Factories\LotFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot whereAuctionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot whereCurrentPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot whereStartingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Lot extends Model
{
    /** @use HasFactory<\Database\Factories\LotFactory> */
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'title',
        'description',
        'starting_price',
        'current_price',
    ];

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
