<?php

// Model: app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'events_products');
    }
}
