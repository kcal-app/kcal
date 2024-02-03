<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Schema\SchemaProvider;

class IngredientAmountSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected string $resourceType = 'ingredient-amounts';

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
        /** @var \App\Models\IngredientAmount $resource */
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
            'nutrientsSummary' => $resource->nutrients_summary,
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
                    return $resource->ingredient; // @codeCoverageIgnore
                },
            ],
            'parent' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['parent']),
                self::DATA => function () use ($resource) {
                    return $resource->parent; // @codeCoverageIgnore
                },
            ]
        ];
    }
}
