<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class GoalSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected $resourceType = 'goals';

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
            'frequency' => $resource->frequency,
            'from' => $resource->from,
            'goal' => $resource->goal,
            'name' => $resource->name,
            'to' => $resource->to,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships): array
    {
        return [
            'user' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['user']),
                self::DATA => function () use ($resource) {
                    return $resource->user;
                },
            ],
        ];
    }
}
