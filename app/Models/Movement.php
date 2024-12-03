<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'cost_type',
        'value',
        'installments',
        'moviment_type',
        'nature_id',
        'payment_type_id',
        'cost_center_id',
        'account_id'
    ];

    /**
     * Relacionamento com a tabela 'accounts'.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Relacionamento com a tabela 'natures'.
     */
    public function nature()
    {
        return $this->belongsTo(Nature::class);
    }

    /**
     * Relacionamento com a tabela 'payment_types'.
     */
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    /**
     * Relacionamento com a tabela 'cost_centers'.
     */
    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }
}
