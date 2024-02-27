<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    const CREATED_AT = 'realizada_em';
    const UPDATED_AT = null;

    protected $fillable = [
        'cliente_id',
        'tipo',
        'valor',
        'descricao'
    ];

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class);
    }

}
