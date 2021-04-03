<?php

namespace App\JsonApi\Adapters;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;

abstract class AdapterBase extends AbstractAdapter
{

    /**
     * {@inheritdoc}
     */
    protected $defaultPagination = ['page' => 1, 'size' => 25];

}
