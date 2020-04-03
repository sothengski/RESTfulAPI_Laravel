<?php

namespace App\Model;

use App\User;

// use Illuminate\Database\Eloquent\Model;

// class Seller extends Model
class Seller extends User
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
