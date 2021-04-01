<?php

namespace App\Models\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\HasTags;

trait Taggable
{
    use HasTags;

    /**
     * Use local app Tag class.
     */
    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    /**
     * Tell `tags` method to use app Tag class.
     */
    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }
}
