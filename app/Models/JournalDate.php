<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\JournalDate
 *
 * @property int $id
 * @property \datetime $date
 * @property int $user_id
 * @property int|null $goal_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Goal|null $goal
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate query()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate whereGoalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalDate whereUserId($value)
 * @mixin \Eloquent
 */
final class JournalDate extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'date',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    /**
     * Get the Goal for this date.
     */
    public function goal(): BelongsTo {
        return $this->belongsTo(Goal::class);
    }

    /**
     * Get the User this journal date belongs to.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
