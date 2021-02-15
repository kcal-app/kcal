<?php

namespace App\Models;

use App\Support\Nutrients;
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
 * @property string|null $frequency
 * @property string $name
 * @property float $goal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $summary
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Goal whereUserId($value)
 * @mixin \Eloquent
 */
final class Goal extends Model
{
    use HasFactory;

    /**
     * Supported options for thr frequency attribute.
     */
    public static array $frequencyOptions = [
        ['value' => 'daily', 'label' => 'daily'],
    ];

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'frequency',
        'from',
        'goal',
        'name',
        'to',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'from' => 'datetime:Y-m-d',
        'goal' => 'float',
        'to' => 'datetime:Y-m-d',
    ];

    /**
     * @inheritdoc
     */
    protected $appends = [
        'summary',
    ];

    /**
     * Get the User this goal belongs to.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function getSummaryAttribute(): string {
        $nameOptions = self::getNameOptions();
        return number_format($this->goal) . "{$nameOptions[$this->name]['unit']} {$nameOptions[$this->name]['label']} {$this->frequency}";
    }

    /**
     * Get options for the "name" column.
     */
    public static function getNameOptions(): array {
        $options = [];
        foreach (Nutrients::$all as $nutrient) {
            $options[$nutrient['value']] = [
                'value' => $nutrient['value'],
                'label' => $nutrient['label'],
                'unit' => $nutrient['unit'],
            ];
        }
        return $options;
    }
}
