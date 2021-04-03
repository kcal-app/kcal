<?php

namespace App\JsonApi\Schemas;

use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * Media schema.
 *
 * "Medium" is the singular form of "media" so it is used for the class name
 * here.
 *
 * @package App\JsonApi\Schemas
 */
class MediumSchema extends SchemaProvider
{

    /**
     * {@inheritdoc}
     */
    protected $resourceType = 'media';

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
        /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $resource */
        $attributes = [
            'uuid' => $resource->uuid,
            'collectionName' => $resource->collection_name,
            'name' => $resource->name,
            'fileName' => $resource->file_name,
            'url' => $resource->getUrl(),
            'mimeType' => $resource->mime_type,
            'size' => $resource->size,
            'sizeFormatted' => $resource->getHumanReadableSizeAttribute(),
            'manipulations' => $resource->manipulations,
            'customProperties' => $resource->custom_properties,
            'conversions' => [],
            'responsiveImages' => $resource->responsive_images,
            'orderColumn' => $resource->order_column,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
        ];

        // Add all conversion URLs.
        foreach ($resource->getGeneratedConversions() as $conversion_name => $generated) {
            if ($generated) {
                $attributes['conversions'][$conversion_name] = $resource->getUrl($conversion_name);
            }
        }

        return $attributes;
    }

    /**
     * @inheritdoc
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships): array
    {
        return [
            'owner' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includeRelationships['model']),
                self::DATA => function () use ($resource) {
                    return $resource->model; // @codeCoverageIgnore
                },
            ]
        ];
    }
}
