<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modalitat extends Model
{
    use HasFactory;

    protected $table = "modalitats";
    protected $fillable = ["nom"];

    public function espai(): BelongsToMany
    {
        return $this->belongsToMany(Espai::class, 'espai_modalitat', "fk_espai", "fk_modalitat");
    }
}
