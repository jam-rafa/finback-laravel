<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'nome',
        'numero_conta',
        'agencia',
        'saldo',
        'account_type',
        'status'
    ];

    /**
     * Relacionamento com a tabela 'movements'.
     */
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
