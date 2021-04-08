<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class DemoSeeder extends Seeder
{
    /**
     * Seed the demo application database.
     */
    public function run(): void
    {
        $this->call(DatabaseSeeder::class);

        // Manually associate demo media files.
        $values = [];
        $conversations = new \stdClass();
        $conversations->header = true;
        $conversations->preview = true;
        $conversations = json_encode($conversations);
        $empty = json_encode([]);
        for ($i = 1; $i <= 25; $i++) {
            $values[] = [
                'id' => $i,
                'model_type' => Recipe::class,
                'model_id' => $i,
                'uuid' => Uuid::uuid4(),
                'collection_name' => 'default',
                'name' => $i,
                'file_name' => "{$i}.jpg",
                'mime_type' => 'image/jpeg',
                'disk'  => 'media',
                'conversions_disk' => 'media',
                'size' => Storage::disk('media')->getSize("{$i}/{$i}.jpg"),
                'manipulations' => $empty,
                'custom_properties' => $empty,
                'generated_conversions' => $conversations,
                'responsive_images' => $empty,
                'order_column' => $i,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('media')->insert($values);
    }
}
