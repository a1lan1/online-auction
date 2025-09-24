<?php

namespace App\Models;

use App\Observers\BidObserver;
use Database\Factories\BidFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $lot_id
 * @property int $user_id
 * @property numeric $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Lot $lot
 * @property-read User $user
 *
 * @method static BidFactory factory($count = null, $state = [])
 * @method static Builder<static>|Bid newModelQuery()
 * @method static Builder<static>|Bid newQuery()
 * @method static Builder<static>|Bid query()
 * @method static Builder<static>|Bid whereAmount($value)
 * @method static Builder<static>|Bid whereCreatedAt($value)
 * @method static Builder<static>|Bid whereId($value)
 * @method static Builder<static>|Bid whereLotId($value)
 * @method static Builder<static>|Bid whereUpdatedAt($value)
 * @method static Builder<static>|Bid whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy([BidObserver::class])]
class Bid extends Model
{
    /** @use HasFactory<BidFactory> */
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'user_id',
        'amount',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function lot(): BelongsTo
    {
        return $this->belongsTo(Lot::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
