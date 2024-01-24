<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentari extends Model
{
    use HasFactory;

    protected $table = "comentaris";
    protected $fillable = ["valoracio", "fk_usuari", "fk_espai", "comentari"];

    public function espai(): BelongsTo
    {
        return $this->belongsTo(Espai::class, "fk_espai");
    }

    public function usuari(): BelongsTo
    {
        return $this->belongsTo(User::class, "fk_usuari");
    }
}
