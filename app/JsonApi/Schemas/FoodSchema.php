<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class FoodSchema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'foods';

    /**
     * @param \App\Models\Food $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Food $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'detail' => $resource->detail,
            'brand' => $resource->brand,
            'calories' => $resource->calories,
            'carbohydrates' => $resource->carbohydrates,
            'cholesterol' => $resource->cholesterol,
            'fat' => $resource->fat,
            'protein' => $resource->protein,
            'sodium' => $resource->sodium,
            'servingSize' => $resource->serving_size,
            'servingSizeFormatted' => $resource->serving_size_formatted,
            'servingUnit' => $resource->serving_unit,
            'servingWeight' => $resource->serving_weight,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];
    }
}
