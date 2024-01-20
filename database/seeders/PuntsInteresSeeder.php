<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuntsInteresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("puntsInteres")->insert([
           ["nom" => "punt 1",
               "descripcio" => "descripcio1",
               "fk_espai" => 1],
            ["nom" => "punt 2",
                "descripcio" => "descripcio2",
                "fk_espai" => 1],
        ]);
    }
}
