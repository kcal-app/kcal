<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RecipeStep
 *
 * @property int $id
 * @property int $recipe_id
 * @property int $number
 * @property string $step
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Recipe $recipe
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep query()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class RecipeStep extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'number',
        'step',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'number' => 'int',
    ];

    /**
     * Get the Recipe this step belongs to.
     */
    public function recipe(): BelongsTo {
        return $this->belongsTo(Recipe::class);
    }
}
