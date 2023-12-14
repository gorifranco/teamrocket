<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servei extends Model
{
    use HasFactory;

    protected $table = "serveis";
    protected $fillable = ["nom"];

    public function espais(): BelongsToMany
    {
        return $this->belongsToMany(Espai::class, 'espai_servei', 'fk_servei', 'fk_espai');
    }
}
