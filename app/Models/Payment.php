<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'installment',
        'installment_value',
        'expiration_date',
        'movements_id',
        'payment_type_id',
        'account_id'
    ];

    // Relacionamento com PaymentType
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
