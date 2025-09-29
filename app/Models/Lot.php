<?php

namespace App\Models;

use App\Enums\LotStatus;
use App\Observers\LotObserver;
use Database\Factories\LotFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property numeric $starting_price
 * @property numeric $current_price
 * @property LotStatus $status
 * @property int $auction_id
 * @property Carbon $starts_at
 * @property Carbon $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $winner_id
 * @property int|null $winning_bid_id
 * @property-read Auction $auction
 * @property-read Collection<int, Bid> $bids
 * @property-read int|null $bids_count
 * @property-read User|null $winner
 * @property-read Bid|null $winnerBid
 *
 * @method static Builder<static>|Lot active()
 * @method static LotFactory factory($count = null, $state = [])
 * @method static Builder<static>|Lot finished()
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
 * @method static Builder<static>|Lot whereStatus($value)
 * @method static Builder<static>|Lot whereTitle($value)
 * @method static Builder<static>|Lot whereUpdatedAt($value)
 * @method static Builder<static>|Lot whereWinnerId($value)
 * @method static Builder<static>|Lot whereWinningBidId($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy([LotObserver::class])]
class Lot extends Model
{
    /** @use HasFactory<LotFactory> */
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'status',
        'description',
        'starting_price',
        'current_price',
        'starts_at',
        'ends_at',
        'auction_id',
        'winner_id',
        'winning_bid_id',
    ];

    public function toSearchableArray(): array
    {
        $this->loadMissing('auction');

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'auction_name' => $this->auction?->name,
            'starting_price' => (float) $this->starting_price,
            'current_price' => (float) $this->current_price,
            'starts_at' => $this->starts_at->getTimestamp(),
            'ends_at' => $this->ends_at->getTimestamp(),
        ];
    }

    public static function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with('auction');
    }

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'status' => LotStatus::class,
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

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function winnerBid(): BelongsTo
    {
        return $this->belongsTo(Bid::class, 'winning_bid_id');
    }

    public function updateStatus(LotStatus $status): void
    {
        $this->update(['status' => $status->value]);
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', LotStatus::ACTIVE)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    #[Scope]
    protected function finished(Builder $query): void
    {
        $query->orWhere('status', LotStatus::FINISHED);
    }
}
