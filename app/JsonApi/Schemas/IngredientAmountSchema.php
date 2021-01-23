<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class IngredientAmountSchema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'ingredient-amounts';

    /**
     * @param \App\Models\IngredientAmount $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\IngredientAmount $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'amount' => $resource->amount,
            'amountFormatted' => $resource->amount_formatted,
            'unit' => $resource->unit,
            'calories' => $resource->calories(),
            'carbohydrates' => $resource->carbohydrates(),
            'cholesterol' => $resource->cholesterol(),
            'fat' => $resource->fat(),
            'protein' => $resource->protein(),
            'sodium' => $resource->sodium(),
            'detail' => $resource->detail,
            'weight' => $resource->weight,
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
            'ingredient' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['ingredient']),
                self::DATA => function () use ($resource) {
                    return $resource->ingredient;
                },
            ],
            'parent' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['parent']),
                self::DATA => function () use ($resource) {
                    return $resource->parent;
                },
            ]
        ];
    }
}
