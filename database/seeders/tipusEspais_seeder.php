<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tipusEspais_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipusEspais')->insert([
            ["nom" => "museu"],
            ["nom" => "hotel"],
            ["nom" => "institucional"],
            ["nom" => "teatre"],
            ["nom" => "biblioteca"],
            ["nom" => "castell"]
        ]);
    }
}
