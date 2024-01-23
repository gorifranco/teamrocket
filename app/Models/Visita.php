<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Visita extends Model
{
    use HasFactory;

    protected $table = "visites";
    protected $fillable = ["nom", "descripcio", "dataInici", "dataFi",
        "reqInscripcio", "places", "fk_espai"];
    protected $with = ["puntsInteres"];

    public function puntsInteres(): BelongsToMany
    {
        return $this->belongsToMany(PuntInteres::class, 'visita_puntInteres', 'fk_visita', 'fk_puntInteres');
    }
    public function espai(): BelongsTo
    {
        return $this->belongsTo(Espai::class, "fk_espai");
    }
}
