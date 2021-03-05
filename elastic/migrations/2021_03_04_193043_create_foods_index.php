<?php
declare(strict_types=1);

use ElasticAdapter\Indices\Mapping;
use ElasticAdapter\Indices\Settings;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreateFoodsIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('foods', function (Mapping $mapping, Settings $settings) {
            $mapping->searchAsYouType('name', ['boost' => 2])
                ->keyword('tags', ['normalizer' => 'lowercase'])
                ->text('detail', ['boost' => 1.5])
                ->text('brand')
                ->text('source')
                ->text('notes')
                ->float('calories')
                ->float('cholesterol')
                ->float('sodium')
                ->float('carbohydrates')
                ->float('protein')
                ->date('created_at')
                ->date('updated_at');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('foods');
    }
}
