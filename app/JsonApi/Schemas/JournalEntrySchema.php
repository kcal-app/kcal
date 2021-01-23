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
}
