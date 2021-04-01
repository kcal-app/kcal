<?php

namespace App\Models;

use App\Models\Traits\HasIngredients;
use App\Models\Traits\Ingredient;
use App\Models\Traits\Journalable;
use App\Models\Traits\Sluggable;
use App\Models\Traits\Taggable;
use ElasticScoutDriverPlus\QueryDsl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
 * @property float|null $weight
 * @property-read float|null $serving_weight
 * @property-read string $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IngredientAmount[] $ingredientAmountRelationships
 * @property-read int|null $ingredient_amount_relationships_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IngredientAmount[] $ingredientAmounts
 * @property-read int|null $ingredient_amounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalEntry[] $journalEntries
 * @property-read int|null $journal_entries_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RecipeStep[] $steps
 * @property-read int|null $steps_count
 * @property-read int|null $tags_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withAllTags($tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withAnyTags($tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withAnyTagsOfAnyType($tags)
 * @mixin \Eloquent
 * @property int|null $time_prep
 * @property int|null $time_cook
 * @property-read int $time_total
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereTimeActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereTimePrep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @property string|null $description_delta
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereDescriptionDelta($value)
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RecipeSeparator[] $ingredientSeparators
 * @property-read int|null $ingredient_separators_count
 * @method static \Database\Factories\RecipeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereTimeCook($value)
 * @property-read Collection $ingredients_list
 */
final class Recipe extends Model implements HasMedia
{
    use HasFactory;
    use HasIngredients;
    use Ingredient;
    use InteractsWithMedia;
    use Journalable;
    use QueryDsl;
    use Searchable;
    use Sluggable;
    use Taggable;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'description',
        'description_delta',
        'time_prep',
        'time_cook',
        'source',
        'servings',
        'weight',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'servings' => 'int',
        'time_prep' => 'int',
        'time_cook' => 'int',
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
        'time_total',
    ];

    /**
     * @inheritdoc
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'tags' => $this->tags->pluck('name')->toArray(),
            'description' => $this->description,
            'source' => $this->source,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Get total recipe time.
     */
    public function getTimeTotalAttribute(): int {
        return $this->time_prep + $this->time_cook;
    }

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
     * Get the ingredients list (ingredient amounts and separators).
     */
    public function getIngredientsListAttribute(): Collection {
        return new Collection([
            ...$this->ingredientAmounts,
            ...$this->ingredientSeparators,
        ]);
    }

    /**
     * Get the steps for this Recipe.
     */
    public function steps(): HasMany {
        return $this->hasMany(RecipeStep::class)->orderBy('number');
    }

    /**
     * Get "separators" for the ingredients.
     *
     * Separators are used to adding headings or simple separations to the
     * ingredients _list_ for a recipe. Their position is defined by weights
     * compatible with ingredient weights.
     */
    public function ingredientSeparators(): HasMany {
        return $this->hasMany(RecipeSeparator::class)
            ->where('container', 'ingredients')
            ->orderBy('weight');
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

    /**
     * Defines conversions for the Recipe image.
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     *
     * @see https://spatie.be/docs/laravel-medialibrary/v9/converting-images/defining-conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->width(368)
            ->height(232)
            ->sharpen(10)
            ->optimize();

        $this->addMediaConversion('header')
            ->fit(Manipulations::FIT_CROP, 1600, 900)
            ->sharpen(10)
            ->optimize();
    }

}
