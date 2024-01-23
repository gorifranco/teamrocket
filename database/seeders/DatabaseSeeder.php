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
        $this->call(illes_seeder::class);
        $this->call(zones_seeder::class);
        $this->call(municipis_seeder::class);
        $this->call(modalitats_seeder::class);
        $this->call(serveis_seeder::class);
        $this->call(tipusEspais_seeder::class);
        $this->call(Users_seeder::class);
        $this->call(Arquitectes_seeder::class);
        $this->call(EspaisSeeder::class);
        $this->call(PuntsInteresSeeder::class);
        $this->call(VisitesSeeder::class);
    }
}
