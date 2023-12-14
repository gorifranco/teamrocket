<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class serveis_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('serveis')->insert([
            ["nom" => "allotjament"],
            ["nom" => "banys"],
            ["nom" => "wifi"]
        ]);
    }
}
