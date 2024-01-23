<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class VisitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('visites')->insert([
            ['nom' => 'Visita1',
                'descripcio' => "descripcio de la primera visita",
                'dataInici' => "2024-01-17",
                'dataFi' => "2024-01-20",
                'reqInscripcio' => true,
                'preu' => 15,
                'places' => 10,
                'fk_espai' => 1],
        ]);
        DB::table('visita_puntInteres')->insert([
            ["fk_visita" => 1,
                "fk_puntInteres" => 1,
                "ordre" => 1],
            ["fk_visita" => 1,
                "fk_puntInteres" => 2,
                "ordre" => 2],
        ]);
    }
}
