<?php

namespace App\Model;

use App\User;

// use Illuminate\Database\Eloquent\Model;

// class Buyer extends Model
class Buyer extends User
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
