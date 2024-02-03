<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Schema\SchemaProvider;

class TagSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected string $resourceType = 'tags';

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
        /** @var \App\Models\Tag $resource */
        return [
            'name' => $resource->name,
            'slug' => $resource->slug,
        ];
    }

}
