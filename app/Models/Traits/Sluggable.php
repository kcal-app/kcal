<?php

namespace App\Models\Traits;

use Cviebrock\EloquentSluggable\Sluggable as SluggableBase;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

trait Sluggable
{
    use SluggableBase;
    use SluggableScopeHelpers;

    /**
     * @inheritdoc
     */
    public function sluggable(): array
    {
        return ['slug' => ['source' => 'name']];
    }

    /**
     * @inheritdoc
     */
    public function getRouteKeyName(): string
    {
        return $this->getSlugKeyName();
    }

    /**
     * @inheritdoc
     */
    public function getRouteKey(): string
    {
        return $this->getSlugKey();
    }
}
