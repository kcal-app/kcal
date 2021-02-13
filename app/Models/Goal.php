<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Goal
 *
 * @property int $id
 * @property int $user_id
 * @property \datetime|null $from
 * @property \datetime|null $to
 * @property string $attribute
 * @property float $goal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereUserId($value)
 * @mixin \Eloquent
 */
class Goal extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'from',
        'to',
        'attribute',
        'goal',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'from' => 'datetime:Y-m-d',
        'to' => 'datetime:Y-m-d',
        'goal' => 'float',
    ];

    /**
     * Get the User this goal belongs to.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
