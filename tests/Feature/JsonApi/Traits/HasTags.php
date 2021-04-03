<?php

namespace Tests\Feature\JsonApi\Traits;

trait HasTags
{
    public function testCanGetRelatedTags(): void {
        $record = $this->createInstances()->first();
        $this->getRelatedData($record, 'tags');
    }

    public function testCanIncludeRelatedTags(): void {
        $record = $this->createInstances()->first();
        $this->getRelatedData($record, 'tags');
    }
}
