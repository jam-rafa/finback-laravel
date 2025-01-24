<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountNature extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'nature_id'];

    // Relacionamento com Account
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Relacionamento com CostCenter
    public function nature()
    {
        return $this->belongsTo(Nature::class);
    }
}
