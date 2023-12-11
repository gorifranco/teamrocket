<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imatge extends Model
{
    use HasFactory;

    protected $table = "imatges";

    public function puntInteres()
    {
        return $this->hasOne(PuntInteres::class, "fk_puntInteres");
    }
}
