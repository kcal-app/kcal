<?php

namespace App\JsonApi\Adapters;

use App\Models\IngredientAmount;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class IngredientAmountAdapter extends AbstractAdapter
{

    /**
     * {@inheritdoc}
     */
    protected $attributes = [];

    /**
     * {@inheritdoc}
     */
    protected $filterScopes = [];

    /**
     * {@inheritdoc}
     */
    protected $defaultSort = ['weight'];

    /**
     * {@inheritdoc}
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new IngredientAmount(), $paging);
    }

    /**
     * {@inheritdoc}
     */
    protected function filter($query, Collection $filters)
    {
        $this->filterWithScopes($query, $filters);
    }

    /**
     * Ingredient relationship.
     */
    protected function ingredient(): BelongsTo
    {
        return $this->belongsTo();
    }

    /**
     * Parent (Recipe or JournalEntry).
     */
    protected function parent(): BelongsTo
    {
        return $this->belongsTo();
    }

}
