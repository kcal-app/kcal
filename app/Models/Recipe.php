<?php

namespace App\Models;

use App\Models\Traits\HasIngredients;
use App\Models\Traits\Ingredient;
use App\Models\Traits\Journalable;
use App\Models\Traits\Sluggable;
use App\Support\Number;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;

/**
 * App\Models\Recipe
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $servings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $description
 * @property string|null $source
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalEntry[] $journalEntries
 * @property-read int|null $journal_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RecipeStep[] $steps
 * @property-read int|null $steps_count
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereServings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IngredientAmount[] $ingredientAmounts
 * @property-read int|null $ingredient_amounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IngredientAmount[] $ingredients
 * @property-read int|null $ingredients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IngredientAmount[] $ingredientAmountChildren
 * @property-read int|null $ingredient_amount_children_count
 * @property-read string $type
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withAllTags($tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withAnyTags($tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withAnyTagsOfAnyType($tags)
 * @property float|null $weight
 * @property-read float|null $serving_weight
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereWeight($value)
 */
final class Recipe extends Model
{
    use HasFactory, HasIngredients, HasTags, Ingredient, Journalable, Sluggable;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'description',
        'source',
        'servings',
        'weight',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'servings' => 'int',
        'weight' => 'float',
    ];

    /**
     * Nutrient per serving methods.
     */
    private array $nutrientPerServingMethods = [
        'caloriesPerServing',
        'carbohydratesPerServing',
        'cholesterolPerServing',
        'fatPerServing',
        'proteinPerServing',
        'sodiumPerServing',
    ];

    /**
     * @inheritdoc
     */
    protected $appends = [
        'serving_weight',
    ];

    /**
     * Get the serving weight (rounded).
     */
    public function getServingWeightAttribute(): ?float {
        if (empty($this->weight)) {
            return null;
        }
        return round($this->weight / $this->servings, 2);
    }

    /**
     * Get the steps for this Recipe.
     */
    public function steps(): HasMany {
        return $this->hasMany(RecipeStep::class)->orderBy('number');
    }

    /**
     * Add nutrient calculations handling to overloading.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     *
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __call($method, $parameters): mixed {
        if (in_array($method, $this->nutrientTotalMethods)) {
            return $this->sumNutrient(substr($method, 0, -5));
        }
        elseif (in_array($method, $this->nutrientPerServingMethods)) {
            $sum = $this->sumNutrient(substr($method, 0, -10)) / $this->servings;

            // Per-serving calculations are rounded, though actual food label
            // rounding standards are more complex.
            if ($sum > 1) {
                return round($sum);
            }
            else {
                return round($sum, 2);
            }
        }
        else {
            return parent::__call($method, $parameters);
        }
    }

}
