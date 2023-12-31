<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Espai extends Model
{
    use HasFactory;

    protected $table = "espais";
    protected $fillable = ["nom", "descripcio", "direccio", "any_construccio", "grau_accessibbilitat", "web",
        "email", "telefon", "fk_arquitecte", "fk_municipi", "fk_tipusEspai"];

    public function modalitats(): BelongsToMany
    {
        return $this->belongsToMany(Modalitat::class, 'espai_modalitat',
            "fk_modalitat", "fk_espai");
    }

    public function arquitecte(): HasOne
    {
        return $this->hasOne(Arquitecte::class, 'fk_arquitecte');
    }

    public function reformes(): HasMany
    {
        return $this->hasMany(DataReforma::class, 'fk_espaiId');
    }

    public function horesActives(): BelongsToMany
    {
        return $this->belongsToMany(horaActiva::class, "espai_horaActiva", "fk_espai", "fk_horaActiva");
    }

    public function serveis(): BelongsToMany
    {
        return $this->belongsToMany(Servei::class, 'espai_servei', 'fk_espai', 'fk_servei');
    }

    public function puntsInteres()
    {
        return $this->hasMany(PuntInteres::class, "fk_espai");
    }

    public function municipi(): HasOne
    {
        return $this->hasOne(Municipi::class, 'fk_municipi');
    }

    public function tipusEspai(): HasOne
    {
        return $this->hasOne(TipusEspai::class, "fk_tipusEspai");
    }

    public function comentaris(): BelongsTo
    {
        return $this->belongsTo(Comentari::class, "fk_espai");
    }
}
