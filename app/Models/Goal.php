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
 * @property-read array $days_formatted
 */
final class Goal extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
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
        'days' => 'int',
        'calories' => 'float',
        'carbohydrates' => 'float',
        'cholesterol' => 'float',
        'fat' => 'float',
        'protein' => 'float',
        'sodium' => 'float',
    ];

    /**
     * @inheritdoc
     */
    protected $appends = [
        'days_formatted',
    ];

    /**
     * Get the days for the goals as strings in array keyed by dow.
     */
    public function getDaysFormattedAttribute(): Collection {
        if (empty($this->days)) {
            return new Collection([]);
        }
        return self::days()->filter(function ($day) {
            if (($this->days & $day['value']) != 0) {
                return true;
            }
            return false;
        });
    }

    /**
     * Get all supported days and metadata.
     *
     * Each entry has the following keys:
     *  - value: Day value (used for bitwise operations).
     *  - label: Human-readable name for the day.
     *  - dow: ISO-8601 numeric representation of the day of the week.
     */
    public static function days(): Collection
    {
        return new Collection([
            [
                'value' => 1,
                'label' => 'monday',
                'dow' => 1,
            ],
            [
                'value' => 2,
                'label' => 'tuesday',
                'dow' => 2,
            ],
            [
                'value' => 4,
                'label' => 'wednesday',
                'dow' => 3,
            ],
            [
                'value' => 8,
                'label' => 'thursday',
                'dow' => 4,
            ],
            [
                'value' => 16,
                'label' => 'friday',
                'dow' => 5,
            ],
            [
                'value' => 32,
                'label' => 'saturday',
                'dow' => 6,
            ],
            [
                'value' => 64,
                'label' => 'sunday',
                'dow' => 7,
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
