<?php

namespace App\Models;

use App\Models\Traits\Journalable;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperFood
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
