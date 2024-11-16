<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    // Em app/Models/User.php
    // Em app/Models/Account.php
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_accounts')->withTimestamps();
    }
}
