<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class JournalEntrySchema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'journal-entries';

    /**
     * @param \App\Models\JournalEntry $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\JournalEntry $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
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
                    return $resource->user;
                },
            ],
            'foods' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['foods']),
                self::DATA => function () use ($resource) {
                    return $resource->foods;
                },
            ],
            'recipes' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['recipes']),
                self::DATA => function () use ($resource) {
                    return $resource->recipes;
                },
            ]
        ];
    }
}
