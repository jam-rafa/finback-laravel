<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountEntities extends Model
{
    use HasFactory;

    protected $table = 'account_entities';

    protected $fillable = [
        'account_id',
        'entities_id',
    ];
}
