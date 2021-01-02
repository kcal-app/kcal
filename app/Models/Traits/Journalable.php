<?php

namespace App\Models\Traits;

use App\Models\JournalEntry;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Journalable
{
    /**
     * Get all of the journal entries for the recipe.
     */
    public function journalEntries(): MorphToMany {
        return $this->morphToMany(JournalEntry::class, 'journalable');
    }
}
