<?php

namespace App\JsonApi\Adapters;

use App\Models\JournalEntry;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use CloudCreativity\LaravelJsonApi\Eloquent\MorphHasMany;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class JournalEntryAdapter extends AdapterBase
{

    /**
     * @inheritdoc
     */
    protected $attributes = [];

    /**
     * @inheritdoc
     */
    protected $filterScopes = [];

    /**
     * {@inheritdoc}
     */
    protected $defaultSort = ['-date'];

    /**
     * @inheritdoc
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new JournalEntry(), $paging);
    }

    /**
     * @inheritdoc
     */
    protected function filter($query, Collection $filters)
    {
        $this->filterWithScopes($query, $filters);
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo();
    }

    protected function foods(): MorphHasMany
    {
        return $this->morphMany($this->hasMany('foods'));
    }

    protected function recipes(): MorphHasMany
    {
        return $this->morphMany($this->hasMany('recipes'));
    }

}
