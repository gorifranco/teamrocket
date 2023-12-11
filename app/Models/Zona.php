<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zona extends Model
{
    use HasFactory;

    protected $table = "zones";

    public function municipi(): BelongsTo
    {
        return $this->belongsTo(Municipi::class, "fk_zona");
    }
}
