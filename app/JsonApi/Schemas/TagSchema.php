<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class TagSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected $resourceType = 'tags';

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
            'name' => $resource->name,
            'slug' => $resource->slug,
        ];
    }

}
