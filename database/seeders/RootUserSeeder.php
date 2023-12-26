<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pass = Hash::make("1234");
        DB::table('users')->insert([
            ["name" => "root",
            "email" => "root@webmaster.com",
            "password" =>$pass,
                "tipusUsuari" => "Administrador"]

        ]);
    }
}
