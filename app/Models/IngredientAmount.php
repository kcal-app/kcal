<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IngredientAmount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'amount',
    ];

    /**
     * Get the Ingredient this amount pertains to.
     */
    public function ingredient(): HasOne {
        return $this->hasOne(Ingredient::class);
    }
}
