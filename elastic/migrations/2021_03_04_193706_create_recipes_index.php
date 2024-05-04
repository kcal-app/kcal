<?php
declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class CreateRecipesIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('recipes', function (Mapping $mapping, Settings $settings) {
            $mapping->searchAsYouType('name', ['boost' => 2])
                ->keyword('tags', ['normalizer' => 'lowercase'])
                ->text('description')
                ->text('source')
                ->date('created_at')
                ->date('updated_at');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('recipes');
    }
}
