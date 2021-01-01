<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class JournalableModel extends Model
{
    /**
     * Get all of the journal entries for the recipe.
     */
    public function journalEntries(): MorphToMany {
        return $this->morphToMany(JournalEntry::class, 'journalable');
    }
}
