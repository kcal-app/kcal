<?php

namespace App\Search;

use Algolia\ScoutExtended\Searchable\Aggregator;
use App\Models\Food;
use App\Models\Recipe;

class Ingredient extends Aggregator
{

    /**
     * @inheritdoc
     */
    protected $models = [Food::class, Recipe::class];
}
