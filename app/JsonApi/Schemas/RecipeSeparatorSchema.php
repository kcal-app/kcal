<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Schema\SchemaProvider;

class RecipeSeparatorSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected string $resourceType = 'recipe-separators';

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
        /** @var \App\Models\RecipeSeparator $resource */
        return [
            'container' => $resource->container,
            'weight' => $resource->weight,
            'text' => $resource->text,
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
