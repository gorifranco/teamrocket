<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipusEspai extends Model
{
    use HasFactory;

    protected $table = "tipusEspais";
    protected $fillable = ["nom"];

    public function espais(): HasMany
    {
        return $this->hasMany(Espai::class, "fk_tipusEspai");
    }
}
