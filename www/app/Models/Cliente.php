<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        "nome",
        "limite",
        "saldo"
    ];

    public $timestamps = false;


    public function transacoes(): HasMany {
        return $this->hasMany(Transacao::class);
    }
}
