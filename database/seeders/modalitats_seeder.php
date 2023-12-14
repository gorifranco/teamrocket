<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class modalitats_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modalitats')->insert([
            ["nom" => "pintura"],
            ["nom" => "escultura"],
            ["nom" => "fotografia"]
        ]);
    }
}
