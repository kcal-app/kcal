<?php

namespace App\JsonApi\Schemas;

use CloudCreativity\LaravelJsonApi\Schema\SchemaProvider;

class UserSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected string $resourceType = 'users';

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
        /** @var \App\Models\User $resource */
        return [
            'username' => $resource->username,
            'name' => $resource->name,
            'meals' => $resource->meals,
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
            'goals' => [
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['goals']),
                self::DATA => function () use ($resource) {
                    return $resource->goals; // @codeCoverageIgnore
                },
            ],
            'journal-entries' => [
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['journal-entries']),
                self::DATA => function () use ($resource) {
                    return $resource->journalEntries; // @codeCoverageIgnore
                },
            ],
        ];
    }
}
