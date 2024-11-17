<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCostCenter extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'cost_center_id'];

    // Relacionamento com Account
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Relacionamento com CostCenter
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }
}