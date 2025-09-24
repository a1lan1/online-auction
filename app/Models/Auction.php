<?php

namespace App\Models;

use App\Observers\AuctionObserver;
use Database\Factories\AuctionFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Lot> $lots
 * @property-read int|null $lots_count
 * @property-read User $owner
 *
 * @method static AuctionFactory factory($count = null, $state = [])
 * @method static Builder<static>|Auction newModelQuery()
 * @method static Builder<static>|Auction newQuery()
 * @method static Builder<static>|Auction query()
 * @method static Builder<static>|Auction whereCreatedAt($value)
 * @method static Builder<static>|Auction whereId($value)
 * @method static Builder<static>|Auction whereName($value)
 * @method static Builder<static>|Auction whereUpdatedAt($value)
 * @method static Builder<static>|Auction whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy([AuctionObserver::class])]
class Auction extends Model
{
    /** @use HasFactory<AuctionFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class);
    }
}
