<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class RecipeStepSchema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'recipe-steps';

    /**
     * @param \App\Models\RecipeStep $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\RecipeStep $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'number' => $resource->number,
            'step' => $resource->step,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];
    }
}
