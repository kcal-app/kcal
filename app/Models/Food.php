<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name Food base name.
 * @property ?string detail Some additional detail about the food (e.g. "small" with the name "onion").
 * @property ?string brand Brand name.
 * @property float carbohydrates per serving (g).
 * @property float calories per serving (g).
 * @property float cholesterol per serving (g).
 * @property float fat per serving (g).
 * @property float protein per serving (g).
 * @property float sodium per serving (g).
 * @property float serving_size Size of one serving of the food.
 * @property ?string serving_unit Unit for serving weight (tsp, tbsp, cup, or null).
 * @property float serving_weight per serving (g).
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 */
class Food extends Model
{
    use HasFactory;

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
}
