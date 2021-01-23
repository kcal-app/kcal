<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class RecipeSchema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'recipes';

    /**
     * @param \App\Models\Recipe $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Recipe $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'description' => $resource->description,
            'source' => $resource->source,
            'servings' => $resource->servings,
            'caloriesPerServing' => $resource->caloriesPerServing(),
            'carbohydratesPerServing' => $resource->carbohydratesPerServing(),
            'cholesterolPerServing' => $resource->cholesterolPerServing(),
            'fatPerServing' => $resource->fatPerServing(),
            'proteinPerServing' => $resource->proteinPerServing(),
            'sodiumPerServing' => $resource->sodiumPerServing(),
            'caloriesTotal' => $resource->caloriesTotal(),
            'carbohydratesTotal' => $resource->carbohydratesTotal(),
            'cholesterolTotal' => $resource->cholesterolTotal(),
            'fatTotal' => $resource->fatTotal(),
            'proteinTotal' => $resource->proteinTotal(),
            'sodiumTotal' => $resource->sodiumTotal(),
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];
    }
}
