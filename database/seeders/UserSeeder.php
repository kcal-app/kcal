<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.admin',
            'password' => '$2y$10$Y6AOmxZHpL3ZVCvwhcG1ZOctibIPgOYZyzIuaEqvmaJuZ4Xs.odxu', // Same as email.
            'remember_token' => Str::random(10),
        ]);
    }
}
