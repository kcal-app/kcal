<?php

namespace App\Models;

use App\Models\Traits\HasIngredients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * App\Models\JournalEntry
 *
 * @property int $id
 * @property int $user_id
 * @property \datetime $date
 * @property string $summary
 * @property float $calories
 * @property float $fat
 * @property float $cholesterol
 * @property float $sodium
 * @property float $carbohydrates
 * @property float $protein
 * @property string $meal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Food[] $foods
 * @property-read int|null $foods_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Recipe[] $recipes
 * @property-read int|null $recipes_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCarbohydrates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCholesterol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereMeal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereSodium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IngredientAmount[] $ingredients
 * @property-read int|null $ingredients_count
 */
class JournalEntry extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'calories',
        'carbohydrates',
        'cholesterol',
        'date',
        'fat',
        'meal',
        'protein',
        'sodium',
        'summary',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'calories' => 'float',
        'carbohydrates' => 'float',
        'cholesterol' => 'float',
        'date' => 'datetime:Y-m-d',
        'fat' => 'float',
        'protein' => 'float',
        'sodium' => 'float',
    ];

    /**
     * @inheritdoc
     */
    protected $with = ['user', 'foods:id,name,slug', 'recipes:id,name,slug'];

    /**
     * Valid meal options.
     */
    public static array $meals = [
        ['value' => 'breakfast', 'label' => 'Breakfast'],
        ['value' => 'lunch', 'label' => 'Lunch'],
        ['value' => 'dinner', 'label' => 'Dinner'],
        ['value' => 'snacks', 'label' => 'Snacks'],
    ];

    /**
     * Get the User this entry belongs to.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all foods related to this entry.
     */
    public function foods(): MorphToMany {
        return $this->morphedByMany(Food::class, 'journalable');
    }

    /**
     * Get all recipes related to this entry.
     */
    public function recipes(): MorphToMany {
        return $this->morphedByMany(Recipe::class, 'journalable');
    }

}
