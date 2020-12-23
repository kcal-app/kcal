<?php

namespace App\JsonApi\RecipeSteps;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'recipe-steps';

    /**
     * @inheritdoc
     */
    public function getId($resource): string
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\RecipeStep $resource
     *
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'number' => $resource->number,
            'step' => $resource->step,
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
            'recipe' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ]
        ];
    }
}
