<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arquitecte extends Model
{
    use HasFactory;

    protected $table = "arquitectes";

    public function espais(): BelongsTo
    {
        return $this->belongsTo(Espai::class, "fk_arquitecte");
    }
}
