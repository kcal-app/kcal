<?php

namespace App\JsonApi\Adapters;

use App\Models\JournalEntry;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use CloudCreativity\LaravelJsonApi\Eloquent\MorphHasMany;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class JournalEntryAdapter extends AbstractAdapter
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

    /**
     * User relationship.
     */
    protected function user(): BelongsTo
    {
        return $this->belongsTo();
    }

    /**
     * Food relationships.
     */
    protected function foods(): MorphHasMany
    {
        return $this->morphMany($this->hasMany('foods'));
    }

    /**
     * Recipe relationships.
     */
    protected function recipes(): MorphHasMany
    {
        return $this->morphMany($this->hasMany('recipes'));
    }

}
