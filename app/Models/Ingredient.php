<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name
 * @property string unit
 * @property float calories
 * @property float protein
 * @property float fat
 * @property float carbohydrates
 */
class Ingredient extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected array $fillable = [
        'name',
        'unit',
        'calories',
        'protein',
        'fat',
        'carbohydrates',
    ];
}
