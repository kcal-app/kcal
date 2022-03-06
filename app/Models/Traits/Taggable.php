<?php

namespace App\Models\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
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

    /**
     * Updates tags from a request with a "tags" parameter value for any bag.
     */
    public function updateTagsFromRequest(Request $request): void {
        $tags_original = $this->tags;

        $tags = $request->get('tags', []);
        if (!empty($tags)) {
            $this->syncTags(explode(',', $tags));
        }
        elseif ($this->tags->isNotEmpty()) {
            $this->detachTags($this->tags);
        }

        // Refresh and index updated tags.
        $this->refresh()->searchable();

        // Delete any removed tags that are no longer in use.
        $tags_original->diff($this->tags)->each(function (Tag $tag) {
            if ($tag->foods->isEmpty() && $tag->recipes->isEmpty()) {
                $tag->delete();
            }
        });
    }
}
