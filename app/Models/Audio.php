<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Audio extends Model
{
    use HasFactory;

    protected $table = "audios";

    public function puntInteres(): BelongsTo
    {
        return $this->belongsTo(PuntInteres::class, "fk_puntInteres");
    }
}
