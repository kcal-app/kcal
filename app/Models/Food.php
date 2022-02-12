<?php

namespace App\Models;

use App\Models\Traits\Ingredient;
use App\Models\Traits\Journalable;
use App\Models\Traits\Sluggable;
use App\Models\Traits\Taggable;
use App\Support\Number;
use ElasticScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property string|null $source
 * @property string|null $notes
 * @property string|null $serving_unit_name
 * @property-read string $serving_size_formatted
 * @property-read string|null $serving_unit_formatted
 * @property-read string $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IngredientAmount[] $ingredientAmountRelationships
 * @property-read int|null $ingredient_amount_relationships_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalEntry[] $journalEntries
 * @property-read int|null $journal_entries_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read int|null $tags_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereSodium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food withAllTags($tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Food withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Food withAnyTags($tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Food withAnyTagsOfAnyType($tags)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Food withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @method static \Database\Factories\FoodFactory factory(...$parameters)
 * @property-read \Illuminate\Support\Collection $units_supported
 */
final class Food extends Model
{
    use HasFactory;
    use Ingredient;
    use Journalable;
    use Searchable;
    use Sluggable;
    use Taggable;

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
        'source',
        'notes',
        'calories',
        'carbohydrates',
        'cholesterol',
        'fat',
        'protein',
        'sodium',
        'serving_size',
        'serving_unit',
        'serving_unit_name',
        'serving_weight',
    ];

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    protected $appends = [
        'serving_size_formatted',
        'serving_unit_formatted',
        'units_supported',
    ];

    /**
     * @inheritdoc
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'tags' => $this->tags->pluck('name')->toArray(),
            'detail' => $this->detail,
            'brand' => $this->brand,
            'source' => $this->source,
            'notes' => $this->notes,
            'calories' => $this->calories,
            'cholesterol' => $this->cholesterol,
            'sodium' => $this->sodium,
            'carbohydrates' => $this->carbohydrates,
            'protein' => $this->protein,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    /**
     * Get the serving size as a formatted string (e.g. 0.5 = 1/2).
     */
    public function getServingSizeFormattedAttribute(): ?string {
        $result = null;
        if (!empty($this->serving_size)) {
            $result = Number::rationalStringFromFloat($this->serving_size);
        }
        return $result;
    }

    /**
     * Get the "formatted" serving unit (for custom unit support).
     */
    public function getServingUnitFormattedAttribute(): ?string {
        // No unit or unit name can be used for e.g. "bell pepper" or "onion" so
        // the food name will be displayed directly.
        if (empty($this->serving_unit) && empty($this->serving_unit_name)) {
            $unit = null;
        }
        else {
            $unit = $this->serving_unit_name ?? $this->serving_unit ?? 'serving';
        }
        return $unit;
    }

}
