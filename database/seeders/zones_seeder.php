<?php

namespace database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class zones_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('zones')->insert([
            ['nom' => 'Palma'],
            ['nom' => 'Serra de Tramuntana'],
            ['nom' => 'Pla de Mallorca'],
            ['nom' => 'Raiguer'],
            ['nom' => 'Migjorn'],
            ['nom' => 'Llevant'],
            ['nom' => 'Menorca'],
            ['nom' => 'Eivissa'],
            ['nom' => 'Formentera']
        ]);
    }
}
