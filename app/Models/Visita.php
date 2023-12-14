<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Visita extends Model
{
    use HasFactory;

    protected $table = "visites";
    protected $fillable = ["nom", "descripcio", "dataInici", "dataFi",
        "reqInscripcio", "places"];

    public function puntsInteres(): BelongsToMany
    {
        return $this->belongsToMany(PuntInteres::class, 'visita_puntInteres', 'fk_visita', 'fk_puntInteres');
    }


}
