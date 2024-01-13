<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Arquitecte extends Model
{
    use HasFactory;

    protected $table = "arquitectes";
    protected $fillable = ["nom", "data_naix", "descripcio"];

    public function espais(): BelongsToMany
    {
        return $this->belongsToMany(Espai::class, "espai_arquitecte", "fk_arquitecte", "fk_espai");
    }
}
