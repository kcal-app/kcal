<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * TODO: Change this model to track nutrients _directly_.
 */
class JournalEntry extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'date',
        'servings',
        'amount',
        'unit',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'amount' => 'float',
    ];

    /**
     * @inheritdoc
     */
    protected $with = ['recipe', 'food', 'user'];

    /**
     * Get the Recipe this entry belongs to.
     */
    public function recipe(): BelongsTo {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Get the Food this entry belongs to.
     */
    public function food(): BelongsTo {
        return $this->belongsTo(Food::class);
    }

    /**
     * Get the User this entry belongs to.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

}
