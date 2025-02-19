<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entities extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'cpf',
        'account',
        'agency'
    ];

    /**
     * Define o relacionamento many-to-many com Account.
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_entities', 'entities_id', 'account_id')
            ->withTimestamps();
    }
}
