<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('espais')->insert([
            "nom" => "L'almudaina",
            "descripcio" => "El Castell o Palau Reial de l'Almudaina, dit també simplement l'Almudaina, està situat a
             la ciutat de Palma, al costat de la Seu, i fou la residència històrica dels reis de Mallorca. La seva
              titularitat i administració corresponen a l'ens públic Patrimoni Nacional, que gestiona els béns de l'estat
              al servei de la Corona.",
            "direccio" => "Calle Palau Reial , s/n. 07001 Palma Mallorca (Illes Balears), Illes Balears",
            "telefon" => 	"971 214134",
            "email" => "	info@patrimonionacional.es",
            "grau_accessibilitat" => "mitj",
            "any_construccio" => 1343,
            "web" => "https://www.patrimonionacional.es/visita/palacio-real-de-la-almudaina",
            "fk_municipi" => 1,
            "fk_gestor" => 2,
            "fk_tipusEspai" => 1
            ]);
    }
}
