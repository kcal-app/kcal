<?php

namespace App\JsonApi\Ingredients;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'ingredients';

    /**
     * @inheritdoc
     */
    public function getId($resource): string
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Ingredient $resource
     *
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'name' => $resource->name,
            'detail' => $resource->detail,
            'calories' => $resource->calories,
            'carbohydrates' => $resource->carbohydrates,
            'cholesterol' => $resource->cholesterol,
            'fat' => $resource->fat,
            'protein' => $resource->protein,
            'sodium' => $resource->sodium,
            'unitWeight' => $resource->unit_weight,
            'cupWeight' => $resource->cup_weight,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];
    }
}
