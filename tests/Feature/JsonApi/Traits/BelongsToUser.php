<?php

namespace Tests\Feature\JsonApi\Traits;

trait BelongsToUser
{
    public function testCanGetRelatedUser(): void {
        $record = $this->createInstances()->first();
        $this->getRelatedData($record, 'user', 'users');
    }

    public function testCanIncludeRelatedUser(): void {
        $record = $this->createInstances()->first();
        $this->getRelatedData($record, 'user', 'users');
    }
}
