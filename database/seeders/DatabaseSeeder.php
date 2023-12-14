<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(illes_seeder::class);
        $this->call(zones_seeder::class);
        $this->call(municipis_seeder::class);
        $this->call(modalitats_seeder::class);
        $this->call(serveis_seeder::class);
        $this->call(tipusEspais_seeder::class);
    }
}
