<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PuntInteres extends Model
{
    use HasFactory;

    protected $table = "puntsInteres";
    protected $fillable = ["nom", "descripcio", "fk_espai"];

    public function espai(): HasOne
    {
        return $this->hasOne(Espai::class, "fk_espai");
    }

    public function imatge(): BelongsTo
    {
        return $this->belongsTo(Imatge::class, "fk_puntInteres");
    }

    public function audios(): HasMany
    {
        return $this->hasMany(Audio::class, "fk_puntInteres");
    }

    public function visites(): BelongsToMany
    {
        return $this->belongsToMany(Visita::class, 'visita_puntInteres', 'fk_puntInteres', 'fk_visita');
    }
}
