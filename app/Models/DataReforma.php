<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataReforma extends Model
{
    use HasFactory;

    protected $table = "dataReforma";

    public function espai(): BelongsTo
    {
        return $this->belongsTo(Espai::class, 'fk_espaiId');
    }
}
