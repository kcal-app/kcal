<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name Ingredient base name.
 * @property ?string detail Some additional detail about the ingredient (e.g. "small" with the name "onion").
 * @property float carbohydrates (per 100g).
 * @property float calories (per 100g).
 * @property float cholesterol (per 100g).
 * @property float fat (per 100g).
 * @property float protein (per 100g).
 * @property float sodium (per 100g).
 * @property ?float unit_weight Weight of one cup of the ingredient.
 * @property ?float cup_weight Weight of one "unit" (e.g. an egg, onion, etc.) of the ingredient.
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 */
class Ingredient extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'detail',
        'calories',
        'carbohydrates',
        'cholesterol',
        'fat',
        'protein',
        'sodium',
        'unit_weight',
        'cup_weight',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'calories' => 'float',
        'carbohydrates' => 'float',
        'cholesterol' => 'float',
        'cup_weight' => 'float',
        'fat' => 'float',
        'protein' => 'float',
        'sodium' => 'float',
        'unit_weight' => 'float',
    ];
}
