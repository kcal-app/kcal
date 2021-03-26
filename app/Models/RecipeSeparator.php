<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RecipeSeparator
 *
 * @property int $id
 * @property int $recipe_id
 * @property string $container
 * @property int $weight
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Recipe $recipe
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator query()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator whereContainer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeSeparator whereWeight($value)
 * @mixin \Eloquent
 */
class RecipeSeparator extends Model
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'container',
        'weight',
        'text',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'weight' => 'int',
    ];

    /**
     * Get the Recipe this step belongs to.
     */
    public function recipe(): BelongsTo {
        return $this->belongsTo(Recipe::class);
    }
}
