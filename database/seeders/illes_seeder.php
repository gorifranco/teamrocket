<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class illes_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('illes')->insert([
            ['nom' => 'Mallorca'],
            ['nom' => 'Menorca'],
            ['nom' => 'Eivissa'],
            ['nom' => 'Formentera']
        ]);
    }
}
