<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NatureType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nature_id',
    ];
}
