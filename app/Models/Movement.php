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
        'nature_id',
        'payment_type_id',
        'cost_center_id',
    ];
}
