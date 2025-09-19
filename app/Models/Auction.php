<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $starts_at
 * @property \Illuminate\Support\Carbon $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lot> $lots
 * @property-read int|null $lots_count
 * @property-read \App\Models\User $owner
 *
 * @method static \Database\Factories\AuctionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Auction whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Auction extends Model
{
    /** @use HasFactory<\Database\Factories\AuctionFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'starts_at',
        'ends_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lots(): HasMany
    {
        return $this->hasMany(Lot::class);
    }
}
