<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comentari extends Model
{
    use HasFactory;

    protected $table = "comentaris";
    protected $fillable = ["valoracio", "fk_usuari", "fk_espai"];

    public function espai(): HasOne
    {
        return $this->hasOne(Espai::class, "fk_espai");
    }

    public function usuari(): HasOne
    {
        return $this->hasOne(User::class, "fk_usuari");
    }
}
