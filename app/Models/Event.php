<?php

// Model: app/Models/Event.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'events_products');
    }

    public function movements()
    {
        return $this->belongsToMany(Movement::class, 'movements_events')->withPivot('ent_value');
    }
}
