<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int number
 * @property string step
 * @property \App\Models\Recipe recipe
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 */
class RecipeStep extends Model
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
