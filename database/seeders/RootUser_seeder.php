<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RootUser_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ["name" => "root",
                "email" => "root@webmaster.com",
                "password" =>Hash::make("1234"),
                "tipusUsuari" => "Administrador"]

        ]);
    }
}
