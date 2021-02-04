<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class FoodSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected $resourceType = 'foods';

    /**
     * {@inheritdoc}
     */
    public function getId($resource): string
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes($resource): array
    {
        return [
            'slug' => $resource->slug,
            'name' => $resource->name,
            'detail' => $resource->detail,
            'brand' => $resource->brand,
            'source' => $resource->source,
            'notes' => $resource->notes,
            'calories' => $resource->calories,
            'carbohydrates' => $resource->carbohydrates,
            'cholesterol' => $resource->cholesterol,
            'fat' => $resource->fat,
            'protein' => $resource->protein,
            'sodium' => $resource->sodium,
            'servingSize' => $resource->serving_size,
            'servingSizeFormatted' => $resource->serving_size_formatted,
            'servingUnit' => $resource->serving_unit,
            'servingUnitFormatted' => $resource->serving_unit_formatted,
            'servingWeight' => $resource->serving_weight,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
            'showUrl' => route('foods.show', $resource),
            'editUrl' => route('foods.edit', $resource),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships): array
    {
        return [
            'tags' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['tags']),
                self::DATA => function () use ($resource) {
                    return $resource->tags;
                },
            ]
        ];
    }
}
