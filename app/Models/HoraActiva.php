<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HoraActiva extends Model
{
    use HasFactory;

    protected $table = "horaActiva";
    protected $fillable = ["dia", "desde", "fins"];

    public function espais(): BelongsToMany
    {
        return $this->belongsToMany(Espai::class, "espai_horaActiva", "fk_horaActiva", "fk_espai");
    }
}
