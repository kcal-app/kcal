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
        /** @var \App\Models\Goal $resource */
        return [
            'name' => $resource->name,
            'days' => $resource->days,
            'daysFormatted' => $resource->days_formatted,
            'calories' => $resource->calories,
            'carbohydrates' => $resource->carbohydrates,
            'cholesterol' => $resource->cholesterol,
            'fat' => $resource->fat,
            'protein' => $resource->protein,
            'sodium' => $resource->sodium,
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
                    return $resource->user; // @codeCoverageIgnore
                },
            ],
        ];
    }
}
