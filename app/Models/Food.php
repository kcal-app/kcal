<?php

namespace App\Models;

use App\Models\Traits\Journalable;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Food
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $detail
 * @property string|null $brand
 * @property float $serving_size
 * @property string|null $serving_unit
 * @property float $serving_weight
 * @property float $calories
 * @property float $fat
 * @property float $cholesterol
 * @property float $sodium
 * @property float $carbohydrates
 * @property float $protein
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FoodAmount[] $foodAmounts
 * @property-read int|null $food_amounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalEntry[] $journalEntries
 * @property-read int|null $journal_entries_count
 * @method static \Illuminate\Database\Eloquent\Builder|Food findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Food newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food query()
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCarbohydrates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCholesterol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereSodium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Food extends Model
{
    use HasFactory;
    use Sluggable;
    use Journalable;

    /**
     * @inheritdoc
     */
    protected $table = 'foods';

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'detail',
        'brand',
        'calories',
        'carbohydrates',
        'cholesterol',
        'fat',
        'protein',
        'sodium',
        'serving_size',
        'serving_unit',
        'serving_weight',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'calories' => 'float',
        'carbohydrates' => 'float',
        'cholesterol' => 'float',
        'fat' => 'float',
        'protein' => 'float',
        'serving_size' => 'float',
        'serving_weight' => 'float',
        'sodium' => 'float',
    ];

    /**
     * Get the food amounts using this food.
     */
    public function foodAmounts(): HasMany {
        return $this->hasMany(FoodAmount::class);
    }
}
