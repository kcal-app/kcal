<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * App\Models\Goal
 *
 * @property int $id
 * @property int $user_id
 * @property \datetime|null $from
 * @property \datetime|null $to
 * @property int $days
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $calories
 * @property float|null $fat
 * @property float|null $cholesterol
 * @property float|null $sodium
 * @property float|null $carbohydrates
 * @property float|null $protein
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\GoalFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereCarbohydrates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereCholesterol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereSodium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereUserId($value)
 * @mixin \Eloquent
 */
final class Goal extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'from',
        'to',
        // Bitwise field: mon=1, tue=2, wed=4, thu=8, fri=16, sat=32, sun=64.
        'days',
        'calories',
        'carbohydrates',
        'cholesterol',
        'fat',
        'protein',
        'sodium',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'from' => 'datetime:Y-m-d',
        'to' => 'datetime:Y-m-d',
        'days' => 'int',
        'calories' => 'float',
        'carbohydrates' => 'float',
        'cholesterol' => 'float',
        'fat' => 'float',
        'protein' => 'float',
        'sodium' => 'float',
    ];

    /**
     * Get all supported days and metadata.
     *
     * Each entry has the following keys:
     *  - value: Day value (used for bitwise operations).
     *  - label: Human-readable name for the day.
     */
    public static function days(): Collection
    {
        return new Collection([
            [
                'value' => 1,
                'label' => 'monday',
            ],
            [
                'value' => 2,
                'label' => 'tuesday',
            ],
            [
                'value' => 4,
                'label' => 'wednesday',
            ],
            [
                'value' => 8,
                'label' => 'thursday',
            ],
            [
                'value' => 16,
                'label' => 'friday',
            ],
            [
                'value' => 32,
                'label' => 'saturday',
            ],
            [
                'value' => 64,
                'label' => 'sunday',
            ],
        ]);
    }

    /**
     * Get the User this goal belongs to.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
