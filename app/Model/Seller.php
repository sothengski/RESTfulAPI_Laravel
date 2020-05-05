<?php

namespace App\Model;

use App\Scopes\SellerScope;
use App\User;
use App\Transformers\SellerTransformer;


// use Illuminate\Database\Eloquent\Model;

// class Seller extends Model
class Seller extends User
{
    public $transformer = SellerTransformer::class;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SellerScope);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
