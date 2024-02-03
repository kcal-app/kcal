<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Schema\SchemaProvider;

class JournalEntrySchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected string $resourceType = 'journal-entries';

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
        /** @var \App\Models\JournalEntry $resource */
        return [
            'calories' => $resource->calories,
            'carbohydrates' => $resource->carbohydrates,
            'cholesterol' => $resource->cholesterol,
            'date' => $resource->date,
            'fat' => $resource->fat,
            'meal' => $resource->meal,
            'protein' => $resource->protein,
            'sodium' => $resource->sodium,
            'summary' => $resource->summary,
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
            'user' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['user']),
                self::DATA => function () use ($resource) {
                    return $resource->user; // @codeCoverageIgnore
                },
            ],
            'foods' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['foods']),
                self::DATA => function () use ($resource) {
                    return $resource->foods; // @codeCoverageIgnore
                },
            ],
            'recipes' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['recipes']),
                self::DATA => function () use ($resource) {
                    return $resource->recipes; // @codeCoverageIgnore
                },
            ]
        ];
    }
}
