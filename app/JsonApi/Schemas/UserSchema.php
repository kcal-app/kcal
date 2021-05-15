<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

class UserSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected $resourceType = 'users';

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
