<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class municipis_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('municipis')->insert([
            ['nom' => 'Alaior', 'fk_illa' => '2', 'fk_zona' => '7'],
            ['nom' => 'Alaró', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Alcúdia', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Algaida', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Andratx', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Ariany', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Artà', 'fk_illa' => '1', 'fk_zona' => '6'],
            ['nom' => 'Banyalbufar', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Binissalem', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Búger', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Bunyola', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Calvià', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Campanet', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Campos', 'fk_illa' => '1', 'fk_zona' => '5'],
            ['nom' => 'Capdepera', 'fk_illa' => '1', 'fk_zona' => '6'],
            ['nom' => 'es Castell', 'fk_illa' => '2', 'fk_zona' => '7'],
            ['nom' => 'Ciutadella', 'fk_illa' => '2', 'fk_zona' => '7'],
            ['nom' => 'Consell', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Costitx', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Deià', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Eivissa', 'fk_illa' => '3', 'fk_zona' => '8'],
            ['nom' => 'Escorca', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Esporles', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Estellencs', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Felanitx', 'fk_illa' => '1', 'fk_zona' => '5'],
            ['nom' => 'Ferreries', 'fk_illa' => '2', 'fk_zona' => '7'],
            ['nom' => 'Formentera', 'fk_illa' => '4', 'fk_zona' => '9'],
            ['nom' => 'Fornalutx', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Inca', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Lloret de Vistalegre', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Lloseta', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Llubí', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Llucmajor', 'fk_illa' => '1', 'fk_zona' => '5'],
            ['nom' => 'Manacor', 'fk_illa' => '1', 'fk_zona' => '8'],
            ['nom' => 'Mancor de la Vall', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Maó', 'fk_illa' => '2', 'fk_zona' => '7'],
            ['nom' => 'Maria de la Salut', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Marratxí', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Es Mercadal', 'fk_illa' => '2', 'fk_zona' => '7'],
            ['nom' => 'Es 5 Gran', 'fk_illa' => '2', 'fk_zona' => '7'],
            ['nom' => 'Montuïri', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Muro', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Palma', 'fk_illa' => '1', 'fk_zona' => '1'],
            ['nom' => 'Petra', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Sa Pobla', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Pollença', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Porreres', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Puigpunyent', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Ses Salines', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Sant Antoni de Portmany', 'fk_illa' => '3', 'fk_zona' => '8'],
            ['nom' => 'Sant Joan', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Sant Joan de Labritja', 'fk_illa' => '3', 'fk_zona' => '8'],
            ['nom' => 'Sant Josep de sa Talaia', 'fk_illa' => '3', 'fk_zona' => '8'],
            ['nom' => 'Sant Llorenç des Cardassar', 'fk_illa' => '1', 'fk_zona' => '8'],
            ['nom' => 'Sant Lluís', 'fk_illa' => '2', 'fk_zona' => '7'],
            ['nom' => 'Santa Eugènia', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Santa Eulària des Riu', 'fk_illa' => '3', 'fk_zona' => '8'],
            ['nom' => 'Santa Margalida', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Santa Maria del Camí', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Santanyí', 'fk_illa' => '1', 'fk_zona' => '5'],
            ['nom' => 'Selva', 'fk_illa' => '1', 'fk_zona' => '4'],
            ['nom' => 'Sencelles', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Sineu', 'fk_illa' => '1', 'fk_zona' => '3'],
            ['nom' => 'Sóller', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Son Servera', 'fk_illa' => '1', 'fk_zona' => '8'],
            ['nom' => 'Valldemossa', 'fk_illa' => '1', 'fk_zona' => '2'],
            ['nom' => 'Vilafranca de Bonany', 'fk_illa' => '1', 'fk_zona' => '3'],
        ]);
    }
}
