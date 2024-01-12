<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Arquitectes_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("arquitectes")->insert([
            [
                "nom" => "Lluís Domènech i Montaner",
                "data_naix" => "1850-12-21",
                "descripcio" => "Lluís Domènech i Montaner va ser un destacat arquitecte espanyol del modernisme català, nascut el 1850 i mort el 1923.
                     És conegut per obres emblemàtiques com l'Hospital de Sant Pau i el Palau de la Música Catalana a
                      Barcelona, que reflecteixen la seva contribució significativa al desenvolupament arquitectònic de la ciutat durant el segle XIX i principis del XX."
            ],[
                "nom" => 'Joan Rubió i Bellver',
                "data_naix" => '1871-4-24',
                "descripcio" => "Joan Rubió i Bellver va ser un arquitecte català, nascut el 23 de febrer de 1870 a Reus
                 i mort el 30 de març de 1952 a Barcelona. Va ser un alumne de Antoni Gaudí i col·laborador en diversos projectes modernistes, destacant per la seva contribució a
  la Sagrada Família. També és conegut per la Casa Ramos a Reus. La seva obra reflecteix la influència i col·laboració amb
   altres importants arquitectes modernistes de l'època."
            ]
        ]);
    }
}
