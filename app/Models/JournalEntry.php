<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @mixin IdeHelperJournalEntry
 */
class JournalEntry extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'calories',
        'carbohydrates',
        'cholesterol',
        'date',
        'fat',
        'meal',
        'protein',
        'sodium',
        'summary',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'calories' => 'float',
        'carbohydrates' => 'float',
        'cholesterol' => 'float',
        'date' => 'datetime:Y-m-d',
        'fat' => 'float',
        'protein' => 'float',
        'sodium' => 'float',
    ];

    /**
     * @inheritdoc
     */
    protected $with = ['user', 'foods:id,name,slug', 'recipes:id,name,slug'];

    /**
     * Get the User this entry belongs to.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all recipes related to this entry.
     */
    public function foods(): MorphToMany {
        return $this->morphedByMany(Food::class, 'journalable');
    }

    /**
     * Get all recipes related to this entry.
     */
    public function recipes(): MorphToMany {
        return $this->morphedByMany(Recipe::class, 'journalable');
    }

}
