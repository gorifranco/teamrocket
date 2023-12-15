<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Municipi extends Model
{
    use HasFactory;

    protected $table = "municipis";

    public function espais(): BelongsTo
    {
        return $this->belongsTo(Espai::class, "fk_municipi");
    }

    public function illa(): HasOne
    {
        return $this->hasOne(Illa::class, "fk_illa");
    }

    public function zona(): HasOne
    {
        return $this->hasOne(Zona::class, "fk_zona");
    }
}
