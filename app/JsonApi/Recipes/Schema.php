<?php

namespace App\JsonApi\Recipes;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'recipes';

    /**
     * @inheritdoc
     */
    public function getId($resource): string
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Recipe $resource
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'name' => $resource->name,
            'description' => $resource->description,
            'servings' => $resource->servings,
            'caloriesPerServing' => $resource->caloriesPerServing(),
            'caloriesTotal' => $resource->caloriesTotal(),
            'carbohydratesPerServing' => $resource->carbohydratesPerServing(),
            'carbohydratesTotal' => $resource->carbohydratesTotal(),
            'cholesterolPerServing' => $resource->cholesterolPerServing(),
            'cholesterolTotal' => $resource->cholesterolTotal(),
            'fatPerServing' => $resource->fatPerServing(),
            'fatTotal' => $resource->fatTotal(),
            'proteinPerServing' => $resource->proteinPerServing(),
            'proteinTotal' => $resource->proteinTotal(),
            'sodiumPerServing' => $resource->sodiumPerServing(),
            'sodiumTotal' => $resource->sodiumTotal(),
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships): array
    {
        return [
            'steps' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['steps']),
                self::DATA => function () use ($resource) {
                    return $resource->steps;
                },
            ],
            'food-amounts' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['food-amounts']),
                self::DATA => function () use ($resource) {
                    return $resource->foodAmounts;
                },
            ]
        ];
    }
}
