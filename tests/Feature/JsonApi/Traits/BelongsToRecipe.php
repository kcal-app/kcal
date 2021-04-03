<?php

namespace Tests\Feature\JsonApi\Traits;

trait BelongsToRecipe
{
    public function testCanGetRelatedUser(): void {
        $record = $this->createInstances()->first();
        $this->getRelatedData($record, 'recipe', 'recipes');
    }

    public function testCanIncludeRelatedUser(): void {
        $record = $this->createInstances()->first();
        $this->getRelatedData($record, 'recipe', 'recipes');
    }
}
