<?php

namespace App\Models;

use App\Support\Nutrients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
        // Bitwise field: sun=1, mon=2, tue=4, wed=8, thu=16, fri=32, sat=64.
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
     * Get the User this goal belongs to.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
